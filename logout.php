<?php

session_start();
$_SESSION = array(); //vider la session
session_destroy();

setcookie('user', '', time() - 3600, '/');

header('Location: /index.php');
exit();