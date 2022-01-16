<?php

spl_autoload_register(function ($class_name) {
    include_once($_SERVER["DOCUMENT_ROOT"] . "\/class\/" . $class_name . ".php");
});

session_start();

include_once($_SERVER["DOCUMENT_ROOT"]."/include/includeDATABASE.php");

