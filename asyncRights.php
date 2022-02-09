<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");

function displayUsersForRights($connect){
    $ret = "";

    try {

    }catch (PDOException $e){
        echo "SQL Error : " . $e->getLine() . $e->getMessage();
    }

}

function createTabUsers($tabRights){

    $tabUsers = Array();
    foreach ($tabRights as $right){

        $user = explode("-",$right)[4];
        if(!(in_array($user, $tabUsers))){
            array_push($tabUsers,$user);
        }
        //echo $user;

    }

    return $tabUsers;
}


function stringRightsToTab($stringRights){

    $finalTabRights = Array();
    $tabStringRights = explode("/",$stringRights);
    $tabUsers = createTabUsers($tabStringRights);


    foreach($tabUsers as $user){
        $finalTabRights[$user] = Array("modify" => 0, "file" => 0, "delete" => 0);
    }

    //  format de variable $parsing plus bas => "check-right-u-file-3"
    foreach($tabStringRights as $stringRight){
        $parsing = explode("-",$stringRight);
        $finalTabRights[$parsing[4]][$parsing[3]] = 1;

    }

    //var_dump($finalTabRights);
    return $finalTabRights;

}





function verifyStatus($connect,$idForm){


    try {
        $status = $connect->query("SELECT status FROM Form WHERE id=".$idForm." ")->fetch();


    }catch (PDOException $e){
        echo "SQL ERROR : " .$e->getMessage(). "line : ". $e->getLine();
        exit;
    }

    return $status['status'];
}


function deleteRights($connect,$idForm){

    $connect->beginTransaction();
    try {

        $stmt = $connect->prepare("DELETE FROM Rights WHERE id_form = ".$idForm." ");
        $stmt->execute();

        $connect->commit();
    }catch(PDOException $e){
        echo "SQL ERROR : " . $e->getLine() . "   " . $e->getMessage();
        $connect->rollback();
        exit;
    }
}

function createRights($connect,$stringRights,$idForm,$idOwner){

    $tabRights = stringRightsToTab($stringRights);
    $tabKeys= array_keys($tabRights);

    $connect->beginTransaction();
    try {


        foreach ($tabKeys as $user){
            $stmt = $connect->prepare("INSERT INTO Rights(id_form, id_owner,id_guest,to_read,to_modify,to_delete)
                                       VALUES(". $idForm .",
                                              ". $idOwner .",
                                              ". $user .",
                                              ". $tabRights[$user]['file'] .",
                                              ". $tabRights[$user]['modify'] .",
                                              ". $tabRights[$user]['delete'] .")
                                              ");
            $stmt->execute();
        }

        $connect->commit();
    }catch(PDOException $e){
        echo "SQL ERROR : " . $e->getLine() . "   " . $e->getMessage();
        $connect->rollback();
        exit;
    }

}



//TODO GERER LES CONFLITS ENTRE LES DIFFERENTS BOUTONS ET RACCOURCIR LES FONCTIONS
function setStatusForm($connect,$idForm, $status){
    $connect->beginTransaction();
    try {

        $stmt = $connect->prepare("UPDATE Form 
                                   SET status = ". $connect->quote($status). " 
                                   WHERE id = ".$idForm." ");
        $stmt->execute();

        $connect->commit();
    }catch(PDOException $e){
        echo "SQL ERROR : " . $e->getLine() . "   " . $e->getMessage();
        $connect->rollback();
        exit;
    }

    return $status;
}



$idForm = $_POST['id-form'];
$stringCheckedRights = $_POST['checked-rights'];
$todo = $_POST['todo'];
$idOwner = $_POST['owner'];
$groupOrUsers = $_POST['group-or-users'] ?? "null";
$statusToSet = (explode("-",$_POST['todo'])[1]) ?? "null";


$finalString = "";

switch ($todo){
    //TODO Si c'est un groupe, la variable groupOrUsers sera egale à groupe --> gérer ce cas
    //TODO De plus, si on click sur comfirmer sans rien cocher, il y'aura une erreur --> la gerer
    case "rights":

        if(verifyStatus($connect,$idForm) == "private" && $groupOrUsers == "users"){
            //echo " Nous voulons modifier les droits !!!!! :   " ;
            stringRightsToTab($stringCheckedRights);
            deleteRights($connect, $idForm);
            createRights($connect,$stringCheckedRights,$idForm,$idOwner);
        }elseif (verifyStatus($connect,$idForm) == "private" && $groupOrUsers == "users"){

        }

        break;

    case "status-private":
        //echo " Le status que l'on souhaite mettre (private) :     " . $statusToSet ;

        if(verifyStatus($connect,$idForm)!="private"){
            //echo verifyStatus($connect,$idForm);
            $finalString.= setStatusForm($connect,$idForm,"private");
            createRights($connect,$stringCheckedRights,$idForm,$idOwner);
        }
        break;

    case "status-public":
        //echo " Le status que l'on souhaite mettre (public) :     " . $statusToSet ;
        if(verifyStatus($connect,$idForm)!="public"){
            //echo verifyStatus($connect,$idForm);
            $finalString.= setStatusForm($connect,$idForm,"public");
            deleteRights($connect, $idForm);
        }
        break;

    case "status-unreferenced":
        if(verifyStatus($connect,$idForm)!="unreferenced"){
            //echo verifyStatus($connect,$idForm);
            $finalString.= setStatusForm($connect,$idForm,"unreferenced");
            deleteRights($connect, $idForm);
        }
}


echo $finalString; //on retourne seulement un status