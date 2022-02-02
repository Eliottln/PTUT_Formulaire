<?php

/*Get form data*/
$nbChamps = (count($_POST) - 1); //moins le titre
$form_title = explode('/', $_POST['form-title-ID'])[0];
$form_ID = explode('/', $_POST['form-title-ID'])[1];
$form_expire = explode('/', $_POST['form-title-ID'])[2];


if ($nbChamps == 0) {
    header("Location: CreateForm.php?error=1");
    exit();
}

include_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.php");

/*Security */
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

/*Fail if the expiration date has already passed*/
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
            $isRequired = ($parties[2]=='true'?1:0);
            $titleOfInput = $parties[3];

            switch ($typeOfInput) {
                case "radio":
                case "checkbox":
                case "select":
                    $num_question++;
                    $nbchoice = $parties[4];
                    array_push($all_questions, questionToSQLRequest($connect, $num_question, $num_page_ok, $form_ID, $_SESSION['user']['id'], $typeOfInput, $titleOfInput, $isRequired));
                    for ($j = 5; $j < count($parties); $j++) {
                        array_push($all_choices, choiceToSQLRequest($connect, ($j - 4), $num_page_ok, $num_question, $form_ID, $_SESSION['user']['id'], $parties[$j]));
                    }
                    break;
                
                case "range":
                    $num_question++;
                    $format = $parties[4].'/'.$parties[5];
                    array_push($all_questions, questionToSQLRequest($connect, $num_question, $num_page_ok, $form_ID, $_SESSION['user']['id'], $typeOfInput, $titleOfInput, $isRequired, null, null, $format));
                    break;

                case "number":
                    $num_question++;
                    
                    $min = $parties[4];
                    $max = $parties[5];
                    array_push($all_questions, questionToSQLRequest($connect, $num_question, $num_page_ok, $form_ID, $_SESSION['user']['id'], $typeOfInput, $titleOfInput, $isRequired, $min, $max));
                    break;

                case "date":
                    $num_question++;
                    $format = $parties[4];
                    array_push($all_questions, questionToSQLRequest($connect, $num_question, $num_page_ok, $form_ID, $_SESSION['user']['id'], $typeOfInput, $titleOfInput, $isRequired, null, null, $format));
                    break;

                default:
                    $num_question++;
                    array_push($all_questions, questionToSQLRequest($connect, $num_question, $num_page_ok, $form_ID, $_SESSION['user']['id'], $typeOfInput, $titleOfInput, $isRequired));
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
