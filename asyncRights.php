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

    //echo("StringRights :    " . $stringRights.)
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



}



$idForm = $_POST['id-form'];
$stringCheckedRights = $_POST['checked-rights'];
$todo = $_POST['todo'];
$idOwner = $_POST['owner'];
$groupOrUsers = $_POST['group-or-users'] ?? "null";


$finalString = "none";



switch ($todo){

    case "rights":

        if(verifyStatus($connect,$idForm) == "private" && $groupOrUsers == "users" && !empty($stringCheckedRights)){
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
        else if(verifyStatus($connect,$idForm) == "private" && empty($stringCheckedRights) ){//On ouvre le menu d'utilisateurs ou de grp mais on choche rien
            $finalString = "Pas de checkbox checké";
            deleteRights($connect, $idForm);
        }
        else{
            $finalString = "Le formulaire n'est pas en privé";
        }

        break;

    case "status-private":

        if(verifyStatus($connect,$idForm)!="private" && $groupOrUsers == "users" && !empty($stringCheckedRights)){
            $finalString = setStatusForm($connect,$idForm,"private");
            createRights($connect,$stringCheckedRights,$idForm,$idOwner);
            $finalString = "Passage private selection de users";
        }
        else if (verifyStatus($connect,$idForm)!="private" && $groupOrUsers == "group" && !empty($stringCheckedRights)) {
            $finalString = setStatusForm($connect,$idForm,"private");
            $stringCheckedRights = transformStringGroupToUsers($connect,$stringCheckedRights);
            createRights($connect,$stringCheckedRights,$idForm,$idOwner);
            $finalString = "Passage private selection de groupes";
        }
        else{
            $finalString = "pas de modification";
        }
        break;

    case "status-public":

        if(verifyStatus($connect,$idForm)!="public"){
            $finalString = setStatusForm($connect,$idForm,"public");
            deleteRights($connect, $idForm);
        }
        else{
            $finalString = "pas de modification";
        }
        break;

    case "status-unreferenced":
        if(verifyStatus($connect,$idForm)!="unreferenced"){
            $finalString = setStatusForm($connect,$idForm,"unreferenced");
            deleteRights($connect, $idForm);
        }else{
            $finalString = "pas de modification";
        }
}


echo $finalString; //on retourne seulement un status