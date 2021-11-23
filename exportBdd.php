<?php


$dsn = 'mysql:dbname=ptut_site_gestion_form; host=127.0.0.1';
$username = "Hedi";
$password = "hedizair120";




// Create connection

$nbChamps = count($_POST);
$count = '0';

$tabOfMultipleAnswerQuestion = array(); //Contiens toutes les questions à choix multiple de type radio, checkBox ....




var_dump($_POST);

print_r($nbChamps);

//VERIFIER SI CEST UN BOUTON RADIO, A CE MOMENT LA, AJOUTER DANS LA TABLE RADIO LES CHOIX DES QUESTIONS


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
        $typeOfInput = $parties[0];
        $valueOfInput = $parties[1];


        $divpartie2 = explode("q", $parties[2]); //On resplite le mot q6 pour récuperer seulement le 6, soit le num de la question
        $numQuestion = $divpartie2[1];
        echo $numQuestion;


        if($typeOfInput!='radioChoice'){
            $sql .= "INSERT INTO Questions VALUES('" . $numQuestion . "','" . $lastID . "','" . $typeOfInput . "','" . $valueOfInput . "');";
        }
        else{
            array_push($tabOfMultipleAnswerQuestion, $value); // On stock les choix multiples dans une array pour les retraiter après
        }

        $count ++;

    }


    $numChoiceOfQuestion = 0; //Compte le numéro du choix de la question radio
    $sql = initDataBase($sql,$lastID,$tabOfMultipleAnswerQuestion); //On initalise la base de données pour le premier choxi multiple.
    $numChoiceOfQuestion++;

    for($i = 1; $i < count($tabOfMultipleAnswerQuestion);$i++){

        var_dump($tabOfMultipleAnswerQuestion[$i]);

        $parsing1 = explode("/", $tabOfMultipleAnswerQuestion[$i]);
        $valueOfInput1 = $parsing1[1]; // value
        $parsing1_numQuestion = explode("q", $parsing1[2]);
        $numQuestion1 = $parsing1_numQuestion[1];

        //Données de l'itération précedente

        $parsing2 = explode("/", $tabOfMultipleAnswerQuestion[$i-1]);
        $valueOfInput2 = $parsing2[1]; // value
        $parsing2_numQuestion = explode("q", $parsing2[2]);
        $numQuestion2 = $parsing2_numQuestion[1];


        if($numQuestion1 != $numQuestion2){
            //POUR TOUT LES AUTRES TYPE DINPUT, MODIFIER ICI, EN METTANT UN SWITCH OU AUTRE CONDITION
            $sql .= "INSERT INTO Questions VALUES('" . $numQuestion1 . "','" . $lastID . "','" . 'radio' . "','" . null . "');";
            $numChoiceOfQuestion = 0;
            $sql .= "INSERT INTO RadioChoice VALUES('" . $numChoiceOfQuestion . "','" .  $numQuestion1. "','" . $lastID . "','" . $valueOfInput1 . "');";
            $numChoiceOfQuestion++;
        }
        else{
            $sql .= "INSERT INTO RadioChoice VALUES('" . $numChoiceOfQuestion . "','" .  $numQuestion1. "','" . $lastID . "','" . $valueOfInput1 . "');";
            $numChoiceOfQuestion++;
        }


    }

    $connect->exec($sql);



} catch (PDOException $e){
    echo 'Erreur sql : ' . $e->getMessage();
}

$connect = null;








function initDataBase( $_sql, $_lastID, $_tabOfMultipleAnswerQuestion){

    $parsing1 = explode("/", $_tabOfMultipleAnswerQuestion[0]);
    $valueOfInput1 = $parsing1[1]; // value
    $parsing1_numQuestion = explode("q", $parsing1[2]);
    $numQuestion1 = $parsing1_numQuestion[1];

    $_sql .= "INSERT INTO Questions VALUES('" . $numQuestion1 . "','" . $_lastID . "','" . 'radio' . "','" . null . "');";
    $numChoiceOfQuestion = 0; //Compte le numéro du choix de la question radio
    $_sql .= "INSERT INTO RadioChoice VALUES('" . $numChoiceOfQuestion . "','" .  $numQuestion1. "','" . $_lastID . "','" . $valueOfInput1 . "');";

    return $_sql;

}


?>

<div>
    <br>
    <h1>Votre formulaire à bien été enregistré</h1>
</div>



