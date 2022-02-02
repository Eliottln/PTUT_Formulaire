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
        echo $user;

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

    var_dump($finalTabRights);
    return $finalTabRights;

}





function verifyStatus($connect,$idForm){



    try {
        $status = $connect->query("SELECT status FROM Form WHERE id=".$idForm." ")->fetch();


    }catch (PDOException $e){
        echo "SQL ERROR : " . $e->getMessage();
        exit;
    }

    return " \n Le formulaire : " . $idForm . " \n Le status actuel : ".$status['status'] . "   ";
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

function setRights($connect,$stringRights, $idForm){

    $tabRights = stringRightsToTab($stringRights);

    $connect->beginTransaction();

    try {



        $connect->commit();
    }catch(PDOException $e){
        echo "SQL ERROR : " . $e->getLine() . "   " . $e->getMessage();
        $connect->rollback();
        exit;
    }
}

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
}



$idForm = $_POST['id-form'];
$stringCheckedRights = $_POST['checked-rights'];
$todo = $_POST['todo'];
$idOwner = $_POST['owner'];
$statusToSet = (explode("-",$_POST['todo'])[1]) ?? "null";


switch ($todo){

    case "rights":
        $status = verifyStatus($connect,$idForm); //Verifier si le formulaire est publique ou pas
        stringRightsToTab($stringCheckedRights);
        break;

    case "status-private":
        echo " Le status que l'on souhaite mettre (private) : " . $statusToSet ;
        
        if(verifyStatus($connect,$idForm)!="private"){
            setStatusForm($connect,$idForm,"private");
            createRights($connect,$stringCheckedRights,$idForm,$idOwner);
        }
        break;

    case "status-public":
        echo " Le status que l'on souhaite mettre (public) : " . $statusToSet ;
        echo verifyStatus($connect,$idForm);
        setStatusForm($connect,$idForm,"public");
        deleteRights($connect, $idForm);
        break;
}


$finalString = "";

echo "" ;