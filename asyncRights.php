<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");

function displayUsersForRights($connect){
    $ret = "";


    try {

    }catch (PDOException $e){
        echo "SQL Error : " . $e->getLine() . $e->getMessage();
    }

}

function displayGroupsForRights($connect){

}

$idForm = $_POST['id-form'];

$finalString = $idForm;

echo $finalString;