<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/include/includeDATABASE.php");

if(!empty($_POST) && isset($_POST["email"])){
    $user = $connect->query('SELECT * FROM User WHERE email = '.$connect->quote($_POST["email"]))->fetch();

    if(!empty($user) && password_verify($_POST["password"],$user["password"])){  //SUCCES
        unset($user['password']);
        $_SESSION['user'] = $user;

        header("Location: visuAllForms.php"); //TODO changer le lien
        exit();
    }
}

header("Location: index.php"); //ECHEC
exit();