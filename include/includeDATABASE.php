<?php

// Create connection
try {
    //code...

    $dsn = 'mysql:dbname=ptut_site_gestion_form; host=127.0.0.1';  // 'mysql:dbname=p2008444; host=iutbg-lamp.univ-lyon1.fr';
    $username = "Hedi"; //"Hedi";
    $password = "hedizair120"; //"hedizair120";

    $connect = new PDO($dsn, $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (\Throwable $th) {
    try {
        $connect = new PDO("sqlite:../database.db");
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (\Exception $ex) {
        die("Connection failed: " . mysqli_connect_error() . "\n
                $ex->getMessage()");
    }
}
