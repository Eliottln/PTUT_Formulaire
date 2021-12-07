<?php

// Create connection
try {

    $dsn = 'mysql:dbname=p2008444; host=iutbg-lamp.univ-lyon1.fr';
    $username = "p2008444";
    $password = "12008444";

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
