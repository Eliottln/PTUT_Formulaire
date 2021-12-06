<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/include/includeDATABASE.php");

if(!empty($_GET) && isset($_GET["email"])){
    $user = $connect->query('SELECT * FROM Users WHERE email = '.$connect->quote($_GET["email"]))->fetch();

    if(!empty($user) && password_verify($_GET["password"],$user["password"])){  //SUCCES
        $_SESSION['user'] = $user;

        header("Location: CreateForm.php"); //TODO changer le lien
        exit();
    }
}

header("Location: index.php"); //ECHEC
exit();