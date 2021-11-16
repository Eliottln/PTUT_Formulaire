<?php


$dsn = 'mysql:dbname=p2008444; host=iutbg-lamp.univ-lyon1.fr';
$username = "p2008444";
$password = "12008444";




// Create connection

$nbChamps = count($_POST);
$count = '0';

var_dump($_POST);

print_r($nbChamps);

try{
    $connect = new PDO($dsn,$username,$password);
    echo 'connexion réussie :' ;
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO Form VALUES (null,". $nbChamps.");";

    $connect->exec($sql);

    $lastID = $connect->lastInsertId();

    $sql = '';

    echo "New record created successfully. Last inserted ID is: " . $lastID;

    foreach ($_POST as $key => $value){ // On renomme la clé et la valeur en key et value, faire un print_R pour + de detail.
        $parties = explode("/", $value);
        echo '<br>';
        echo $parties[0] . "<br>";
        echo $parties[1] . "<br>";
        echo $parties[2];
        echo '<br>';
        echo '<br>';
        $sql .= "INSERT INTO Questions VALUES('" . $count . "','" . $lastID . "','" . $parties[0] . "','" . $parties[1] . "');";
        $count ++;

    }

    $connect->exec($sql);



} catch (PDOException $e){
    echo 'Erreur sql : ' . $e->getMessage();
}

$connect = null;



?>

<div>
    <br>
    <h1>Votre formulaire à bien été enregistré</h1>
</div>



