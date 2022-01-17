<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");

if (!empty($_POST) && isset($_POST)) {
    $date = date('Y/m/d H:i:s');
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $connect->beginTransaction();
    try {
        $sql = 'INSERT INTO Users (email,name,lastname,password,active,admin,\'update\')
                VALUES (:email,:name,:lastname,:password,1,0,' . $connect->quote($date) . ')';

        $statement = $connect->prepare($sql);

        $statement->bindParam('email', $_POST['email'], PDO::PARAM_STR);
        $statement->bindParam('name', $_POST['fname'], PDO::PARAM_STR);
        $statement->bindParam('lastname', $_POST['lname'], PDO::PARAM_STR);
        $statement->bindParam('password', $password, PDO::PARAM_STR);

        $statement->execute();

        $connect->commit();
    } catch (\Throwable $th) {
        echo $th->getLine() . " " . $th->getMessage();
        $connect->rollBack();
        header('Location: /index.php');
        exit();
    }

    $user = $connect->query('SELECT *
                            FROM Users 
                            WHERE email = ' . $connect->quote($_POST['email']))->fetch();

    unset($user['password']);

    $_SESSION['user'] = $user;
    header('Location: visuAllForms.php');
    exit();
}
