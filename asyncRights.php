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

//Transforme la chaine de caracteres designant les groupes en chaine de caracteres designats que des users

function transformStringGroupToUsers($connect, $stringCheckedRights){
    $finalTabRightsGroups = explode("/",$stringCheckedRights);
    $finalStringRights = "";
    $finalTabRights = Array();
    try {
        foreach ($finalTabRightsGroups as $groupRights){
            $idGroup = explode("-",$groupRights)[4];
            $right = explode("-",$groupRights)[3]; //id_user
            $stmt = $connect->query("SELECT id_user FROM isMember WHERE id_group = ".$idGroup)->fetchAll();

            foreach ($stmt as $user){
                if(!in_array("check-right-u-".$right."-".$user['id_user'],$finalTabRights)){
                    array_push($finalTabRights,"check-right-u-".$right."-".$user['id_user']);
                    $finalStringRights .= "/check-right-u-".$right."-".$user['id_user'];
                }

            }

        }

        $finalStringRights = substr($finalStringRights,1);


    }catch(PDOException $e){
        echo "SQL ERROR : " . $e->getLine() . "   " . $e->getMessage();
        exit;
    }

    return $finalStringRights;

    //TODO pour chaque personne du groupe, créer une chaine du mm exemple de ci-dessus avec le droit indiqué


}



$idForm = $_POST['id-form'];
$stringCheckedRights = $_POST['checked-rights'];
$todo = $_POST['todo'];
$idOwner = $_POST['owner'];
$groupOrUsers = $_POST['group-or-users'] ?? "null";
$statusToSet = (explode("-",$_POST['todo'])[1]) ?? "null";


$finalString = "none";



switch ($todo){
    //TODO Bug lorsque : formulaire en privée, click sur user + aucune check box cochée
    //TODO astuce, créer un nouvel etat dans lequel on a pas afficher les groupe et pas afficher les users donc pas faire de traitement
    //TODO faire un select et pas des boutons

    case "rights":

        //On verifi bien qu'il y'a des checkbox de chekcé, sinon BUG
        if(verifyStatus($connect,$idForm) == "private" && $groupOrUsers == "users" && !empty($stringCheckedRights)){
            //echo " Nous voulons modifier les droits !!!!! :   " ;
            var_dump($stringCheckedRights);
            deleteRights($connect, $idForm);
            createRights($connect,$stringCheckedRights,$idForm,$idOwner);
            $finalString = "changement des droits";
        }
        else if (verifyStatus($connect,$idForm) == "private" && $groupOrUsers == "group" && !empty($stringCheckedRights)){

            $stringCheckedRights = transformStringGroupToUsers($connect,$stringCheckedRights);
            deleteRights($connect, $idForm);
            createRights($connect,$stringCheckedRights,$idForm,$idOwner);
            $finalString = "changements des droits (groupes)";

        }
        else if(empty($stringCheckedRights)){//On ouvre le menu d'utilisateurs ou de grp mais on choche rien
            $finalString = "Pas de checkbox checké";
            deleteRights($connect, $idForm);
        }


        break;

    case "status-private":
        //echo " Le status que l'on souhaite mettre (private) :     " . $statusToSet ;

        if(verifyStatus($connect,$idForm)!="private"){
            //echo verifyStatus($connect,$idForm);
            $finalString = setStatusForm($connect,$idForm,"private");
            createRights($connect,$stringCheckedRights,$idForm,$idOwner);
        }else{
            $finalString = "pas de modification";
        }
        break;

    case "status-public":
        //echo " Le status que l'on souhaite mettre (public) :     " . $statusToSet ;
        if(verifyStatus($connect,$idForm)!="public"){
            //echo verifyStatus($connect,$idForm);
            $finalString = setStatusForm($connect,$idForm,"public");
            deleteRights($connect, $idForm);
        }else{
            $finalString = "pas de modification";
        }
        break;

    case "status-unreferenced":
        if(verifyStatus($connect,$idForm)!="unreferenced"){
            //echo verifyStatus($connect,$idForm);
            $finalString = setStatusForm($connect,$idForm,"unreferenced");
            deleteRights($connect, $idForm);
        }else{
            $finalString = "pas de modification";
        }
}


echo $finalString; //on retourne seulement un status