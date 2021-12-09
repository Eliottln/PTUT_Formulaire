<?php



$nQuestion = 0;
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

    //On crée un document, on ne connait pas encore le nb de questions donc on le met à 0 pour le modifier plus bas
    $sql = "INSERT INTO Document VALUES (null,0);"; //Document
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
                $nQuestion++;
                break;

        }


    }



    $connect->exec($sql);
    //$prepQuery = $connect->prepare($sql);
    //$prepQuery->execute();

    //On ajoute le nombre de question dans le champ nbQuestion dans la table Document
    $sql = 'UPDATE Document SET nbQuestions='. $nQuestion .' WHERE idDocument= '.$lastID .' ;';
    $connect->exec($sql);



} catch (PDOException $e){
    echo 'Erreur sql : ' . $e->getMessage();
}

$connect = null;
$message = 'votre formulaire à bien été enregistré';


header("Location: CreateForm.php");
exit();
// Message d'alerte d'enregistrement : echo '<script type="text/javascript">window.alert("'.$message.'");</script>';









