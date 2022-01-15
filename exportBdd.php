<?php

$nbChamps = (count($_POST)-1); //moins le titre
$form_title = explode('/',$_POST['form-title-ID'])[0];
$form_ID = explode('/',$_POST['form-title-ID'])[1];

if ($nbChamps == 0) {
    header("Location: CreateForm.php?error=1");
    exit();
}

include_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.php");

if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
    header("Location: index.php");
    exit();
}

include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");
foreach (glob($_SERVER["DOCUMENT_ROOT"] . "/modules/export_function/*.php") as $filename)
{
    include $filename;
}


insert_form($connect, $form_ID, $_SESSION['user']['id'], $nbChamps, $form_title);

$connect->beginTransaction();
try {

    $all_questions = array();
    $all_chooses = array();
    $all_input =  array_values($_POST);

    //On crée un document, on ne connait pas encore le nb de questions donc on le met à 0 pour le modifier plus bas
    for ($i=1; $i < count($all_input); $i++) { 
        $parties = explode("/", $all_input[$i]);

        $typeOfInput = $parties[0];
        $titleOfInput = $parties[1];
        

        switch ($typeOfInput){
            case "radio":
            case "checkbox":
            case "select":
                $nbchoose = $parties[2];
                for ($j=3; $j < count($parties); $j++) { 
                    array_push($all_questions, questionToSQLRequest($connect, $i, $form_ID, $_SESSION['user']['id'], $typeOfInput , $titleOfInput, 0));
                    array_push($all_chooses, chooseToSQLRequest($connect, ($j-2),$i, $form_ID, $_SESSION['user']['id'],$parties[$j]));
                }
                break;

            case "number":
            case "range":
                $min = $parties[2];
                $max = $parties[3];
                array_push($all_questions, questionToSQLRequest($connect, $i, $form_ID, $_SESSION['user']['id'], $typeOfInput , $titleOfInput, 0,$min,$max));
                break;

            case "date":
                $format = $parties[2];
                array_push($all_questions, questionToSQLRequest($connect, $i, $form_ID, $_SESSION['user']['id'], $typeOfInput , $titleOfInput, 0,null,null,$format));
                break;

            default:
                array_push($all_questions, questionToSQLRequest($connect, $i, $form_ID, $_SESSION['user']['id'], $typeOfInput , $titleOfInput, 0));
                break;
        }
    }
    
    if(!empty($all_questions)){
        insert_arrayRequest($connect, $all_questions);
    }
    
    if(!empty($all_chooses)){
        insert_arrayRequest($connect, $all_chooses);
    }
    
    $connect->commit();
    $_SESSION['exportSucces'] = true;

} catch (PDOException $e) {
    $connect->rollback();
    echo 'Erreur sql : (line : '. $e->getLine() . ") " . $e->getMessage();
    delete_form($connect, $id_form);
}


header("Location: CreateForm.php?id_form=".$form_ID);
exit();
// Message d'alerte d'enregistrement : echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
