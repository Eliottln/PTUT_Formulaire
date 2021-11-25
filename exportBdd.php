<?php


$dsn = 'mysql:dbname=p2008444; host=iutbg-lamp.univ-lyon1.fr'; //'mysql:dbname=ptut_site_gestion_form; host=127.0.0.1';
$username = "p2008444"; //"Hedi";
$password = "12008444"; //"hedizair120";




$nbChamps = count($_POST);
$count = '0';

$tabOfMultipleAnswerQuestion = array(); //Contiens toutes les questions à choix multiple de type radio, checkBox ....


print_r($nbChamps);


try{
    $connect = new PDO($dsn,$username,$password);
    echo 'connexion réussie :' ;
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO Form VALUES (null,". $nbChamps.");"; //Document

    $connect->exec($sql);

    $lastID = $connect->lastInsertId(); //Numéro du document

    $sql = '';

    echo "New record created successfully. Last inserted ID is: " . $lastID;


    foreach ($_POST as $key => $value){ // On renomme la clé et la valeur en key et value, faire un print_R pour + de detail.

        $parties = explode("/", $value);
        echo '<br>';
        $typeOfInput = $parties[0];
        $valueOfInput = $parties[1];
        $numQuestion = $parties[2];

        //Verif du type de l'input
        switch ($typeOfInput) {
            case "question":
                echo "i est une pomme";
                $sql .= "INSERT INTO Questions VALUES('" . $numQuestion . "','" . $lastID . "','" . $typeOfInput . "','" . null . "');";
                break;
            case "radioQuestion":
                echo "i est une barre";
                $sql .= "INSERT INTO Questions VALUES('" . $numQuestion . "','" . $lastID . "','" . $typeOfInput . "','" . null . "');";
                break;
            case "checkboxQuestion":
                echo "i est un gateau";
                $sql .= "INSERT INTO Questions VALUES('" . $numQuestion . "','" . $lastID . "','" . $typeOfInput . "','" . null . "');";
                break;
            case "radioChoice":
                echo "cerise";
                $sql .= "INSERT INTO RadioChoice VALUES('" . $numQuestion . "','" . $lastID . "','" . $valueOfInput . "','" . null . "');";
                break;
            case "checkboxChoice":
                echo "bibi";
                $sql .= "INSERT INTO CheckBoxChoice VALUES('" . $numQuestion . "','" . $lastID . "','" . 'radio' . "','" . null . "');";
                break;

        }

        echo $typeOfInput . " / ";
        echo $numQuestion;



        $count ++;

    }

    /*//GESTION DES QUESTION A VALEURS MULTIPLES
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


    }*/

    $prepQuery = $connect->prepare($sql);
    $prepQuery->execute();



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



