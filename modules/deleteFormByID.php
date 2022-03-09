<?php

try {
    $connect = new PDO("sqlite:../../database.db");
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\Exception $ex) {
    die("Connection failed: " . mysqli_connect_error() . "\n
                $ex->getMessage()");
}

include_once($_SERVER["DOCUMENT_ROOT"]."/modules/export_function/delete_form.php");

if(!empty($_POST) && !empty($_POST['deleteID'])){
    delete_form($connect,$_POST['deleteID']);

    header("Location: /dashboard.php");
}