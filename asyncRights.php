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

function setStatus($connect,$status, $form){
    $connect->beginTransaction();
    try {
        //modifier le status
        $sql = "UPDATE Form
                SET status = ".$status ."
                WHERE condition";

        $stmt = $connect->prepare($sql);

        $stmt->execute();

        $connect->commit();
    }catch(PDOException $e){
        "ERROR SQL : " . $e->getLine() . "   ". $e->getMessage();
        $connect->rollback();
        exit;
    }
}




function prepareInsertionSql($tabRights,$user,$idForm){
    $tabSql = Array();


    //foreach($tabKey as $key){
        //array_push($tabSql,"INSERT INTO Rights(id_form, id_owner,`read`,id_guest,modify,`delete`)
        //                                  VALUES(".$idForm .",".$user .",". .")");
    //}
}

function verifyStatus($connect,$idForm){



    try {
        $status = $connect->query("SELECT status FROM Form WHERE id=".$idForm." ")->fetch();




    }catch (PDOException $e){
        echo "SQL ERROR : " . $e->getMessage();
        exit;
    }

    return "Le formulaire : " . $idForm . " Le status actuel : ".$status['status'] . "   ";
}

function setRights($connect,$stringRights){

    $tabRights = stringRightsToTab($stringRights);

    $connect->beginTransaction();

    try {

        //$stmt = $connect->prepare("INSERT INTO Rights ")


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
$statusToSet = $_POST['todo'];



if($todo === "rights"){
    $status = verifyStatus($connect,$idForm); //Verifier si le formulaire est publique ou pas
    stringRightsToTab($stringCheckedRights);
}else if($todo === "status"){
    echo verifyStatus($connect,$idForm);

}



$finalString = "";

echo "" ;