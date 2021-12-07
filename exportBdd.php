<?php


$dsn = 'mysql:dbname=ptut_site_gestion_form; host=127.0.0.1';  // 'mysql:dbname=p2008444; host=iutbg-lamp.univ-lyon1.fr';
$username = "Hedi"; //"Hedi";
$password = "hedizair120"; //"hedizair120";

// $connect = new PDO("sqlite:../database.db");


$nbChamps = count($_POST);

if($nbChamps == 0){
    header("Location: index.php");
    exit();
}


$tabOfMultipleAnswerQuestion = array(); //Contiens toutes les questions à choix multiple de type radio, checkBox ....




try{
    //$connect = new PDO($dsn,$username,$password);
    $connect = new PDO("sqlite:../database.db");
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO Document VALUES (null,". $nbChamps.");"; //Document
    $connect->exec($sql);
    $lastID = $connect->lastInsertId(); //Numéro du document
    $sql = '';



    foreach ($_POST as $key => $value){ // On renomme la clé et la valeur en key et value, faire un print_R pour + de detail.

        $parties = explode("/", $value);

        $typeOfInput = $parties[0];
        $valueOfInput = $parties[1];
        $numQuestion = $parties[2];


        //Verif du type de l'input
        switch ($typeOfInput) {

            case "radioChoice":

                $indexQuestion = $parties[3];
                $sql .= "INSERT INTO RadioChoice VALUES('" . $indexQuestion . "','" . $numQuestion . "','".  $lastID ."','" . $valueOfInput ."');";

                break;
            case "checkBoxChoice":

                $indexQuestion = $parties[3];
                $sql .= "INSERT INTO CheckBoxChoice VALUES('". $indexQuestion ."','". $numQuestion . "','" . $lastID . "','" . $valueOfInput . "');";

                break;


            default: // Le cas des champ de question seul, ou des champs de question d'en tete de choix de radio ou check --> (text area)
                $sql .= "INSERT INTO Form VALUES('" . $numQuestion . "','" . $lastID . "','" . $typeOfInput . "','" . $valueOfInput . "');";

                break;

        }


    }

    $connect->exec($sql);
    //$prepQuery = $connect->prepare($sql);
    //$prepQuery->execute();



} catch (PDOException $e){
    echo 'Erreur sql : ' . $e->getMessage();
}

$connect = null;
$message = 'votre formulaire à bien été enregistré';


header("Location: index.php");
exit();
// Message d'alerte d'enregistrement : echo '<script type="text/javascript">window.alert("'.$message.'");</script>';



?>







