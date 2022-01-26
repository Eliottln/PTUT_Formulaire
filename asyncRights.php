<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");

function displayUsersForRights($connect){
    $ret = "";


    try {

    }catch (PDOException $e){
        echo "SQL Error : " . $e->getLine() . $e->getMessage();
    }

}


function stringRightsToTab($stringRights){
    $tab = Array();
    $parsing0 = explode("/",$stringRights); //p4 = user, p3 = droit
    //classer les droits en fonctions des utilisateurs
    foreach ($parsing0 as $right){
        $parsing1 = explode("-",$parsing0);
        $user = $parsing0[4];
    }

    /*EXEMPLE CREATION DUNE TABLE DE DROIT
    $list = array();
    $user = array('modify' => 0, 'read' => 0, 'delete' => 0);
    array_push($list, $user);
    var_dump($list);

    */
    
    //foreach ($parsing0 as $right){
      //  $parsing1 = explode("-", $right);
        //$tab[$parsing1[4]] = $parsing1[3];

    //}

    $tabKey = array_keys($tab);

    return $tab;
    /*foreach($tabKey as $key){
        echo  "Droit : " . $tab[$key] . "  Utilisateur : " . $key . "  " ;
    }*/

}

function prepareInsertionSql($tabRights,$user,$idForm){
    $tabSql = Array();


    //foreach($tabKey as $key){
        //array_push($tabSql,"INSERT INTO Rights(id_form, id_owner,`read`,id_guest,modify,`delete`)
        //                                  VALUES(".$idForm .",".$user .",". .")");
    //}
}

function verifyStatus($idForm){

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
$status = verifyStatus($idForm); //Verifier si le formulaire est publique ou pas

$finalString = "";
stringRightsToTab($stringCheckedRights);
echo $finalString ;