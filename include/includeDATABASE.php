<?php

// Create connection
    try {
        $connect = new PDO("sqlite:../database.db");
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (\Exception $ex) {
        die("Connection failed: " . mysqli_connect_error() . "\n
                $ex->getMessage()");
    }
//}
