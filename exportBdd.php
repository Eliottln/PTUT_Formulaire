<?php

/*Recup form data*/
$nbChamps = (count($_POST) - 1); //moins le titre
$form_title = explode('/', $_POST['form-title-ID'])[0];
$form_ID = explode('/', $_POST['form-title-ID'])[1];
$form_expire = explode('/', $_POST['form-title-ID'])[2];


if ($nbChamps == 0) {
    header("Location: CreateForm.php?error=1");
    exit();
}

include_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.php");

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$origin = date_create(date("Y-m-d"));
$target = date_create($form_expire);
$interval = date_diff($origin, $target);
if ($interval->format('%R%a') < 0) {
    $_SESSION['exportWrongExpiredDate'] = true;
    header("Location: CreateForm.php?id_form=" . $form_ID);
    exit();
}

include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");
foreach (glob($_SERVER["DOCUMENT_ROOT"] . "/modules/export_function/*.php") as $filename) {
    include $filename;
}

$nbPage = count(preg_grep("/^page/", $_POST));
insert_form($connect, $form_ID, $_SESSION['user']['id'], $nbPage, $form_title, $form_expire);


$connect->beginTransaction();
try {

    $all_pages = array();
    $all_questions = array();
    $all_choices = array();
    $all_input =  array_values($_POST);
    $num_page = 0;
    $num_page_ok = 0;
    $num_question = 0;

    //On crée un document, on ne connait pas encore le nb de questions donc on le met à 0 pour le modifier plus bas
    for ($i = 1; $i < count($all_input); $i++) {
        $parties = explode("/", $all_input[$i]);


        $typeOfInput = $parties[0];
        $titleOfInput = $parties[1];
        if ($typeOfInput == 'page') {
            $num_page++;
            $nb = count(preg_grep("/^in_page" . $num_page . "/", $_POST)); //nb_question
            

            $colorToSend = NULL; // TODO recup theme color
            if ($nb > 0) {
                $num_page_ok++;
                array_push($all_pages, pageToSQLRequest($connect, $num_page_ok, $form_ID, $_SESSION['user']['id'], $nb, $titleOfInput, $colorToSend));
            }
        } else {
            $typeOfInput = $parties[1];
            $titleOfInput = $parties[2];

            switch ($typeOfInput) {
                case "radio":
                case "checkbox":
                case "select":
                    $num_question++;
                    $nbchoice = $parties[3];
                    array_push($all_questions, questionToSQLRequest($connect, $num_question, $num_page, $form_ID, $_SESSION['user']['id'], $typeOfInput, $titleOfInput, 0));
                    for ($j = 4; $j < count($parties); $j++) {
                        array_push($all_choices, choiceToSQLRequest($connect, ($j - 3), $num_page, $num_question, $form_ID, $_SESSION['user']['id'], $parties[$j]));
                    }
                    break;

                case "number":
                case "range":
                    $num_question++;
                    $min = $parties[3];
                    $max = $parties[4];
                    array_push($all_questions, questionToSQLRequest($connect, $num_question, $num_page, $form_ID, $_SESSION['user']['id'], $typeOfInput, $titleOfInput, 0, $min, $max));
                    break;

                case "date":
                    $num_question++;
                    $format = $parties[3];
                    array_push($all_questions, questionToSQLRequest($connect, $num_question, $num_page, $form_ID, $_SESSION['user']['id'], $typeOfInput, $titleOfInput, 0, null, null, $format));
                    break;

                default:
                    $num_question++;
                    array_push($all_questions, questionToSQLRequest($connect, $num_question, $num_page, $form_ID, $_SESSION['user']['id'], $typeOfInput, $titleOfInput, 0));
                    break;
            }
        }
    }


    if (!empty($all_pages)) {
        insert_arrayRequest($connect, $all_pages);

        if (!empty($all_questions)) {
            insert_arrayRequest($connect, $all_questions);

            if (!empty($all_choices)) {
                insert_arrayRequest($connect, $all_choices);
            }
        }
    }

    
    $connect->commit();
    $_SESSION['exportSucces'] = true;
} catch (PDOException $e) {
    $connect->rollback();
    echo 'Erreur sql : (line : ' . $e->getLine() . ") " . $e->getMessage();
    delete_form($connect, $id_form);
    $_SESSION['exportFailed'] = true;
}


header("Location: CreateForm.php?id_form=" . $form_ID);
exit();
// Message d'alerte d'enregistrement : echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
