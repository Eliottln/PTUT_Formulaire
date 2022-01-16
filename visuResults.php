<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");
foreach (glob($_SERVER["DOCUMENT_ROOT"] . "/modules/vue_form/*.php") as $filename) {
    include $filename;
}

if (empty($_GET['identity'])) {

    if (!empty($_POST)) {
        sendMyResponse($connect, $_POST);
    }

    header("Location: dashboard.php");
    exit();
}


function displayResults($connect)
{
    $resultString = "<h2>Les résultats de ce formulaires sont:</h2> <br>";

    try {

        $results = $connect->query("SELECT * FROM Results WHERE id_form = ". $_GET['identity'] . " ")->fetchAll();

        $currentUser = "";

        foreach($results as $value){
            if($currentUser != $value['id_user']){
                $resultString .= "<br>";
                $currentUser = $value['id_user'];
            }
            $currentUser = $value['id_user'];
            $question = $connect->query("SELECT title FROM Questions WHERE id_form = ". $_GET['identity'] ." AND id = ". $value['id_question'] ." ")->fetch();
            $resultString .= "Question : ". $question['title']." -> ID user :". $value['id_user'] ." --> " . $value['answer'] . "<br>";

        }

    } catch (PDOException $e) {
        echo 'Erreur sql : (line : ' . $e->getLine() . ") " . $e->getMessage();

    }

    return $resultString;
}

?>

<!DOCTYPE html>
<html lang="fr">

<?php
$pageName = "Resultats " . $_GET['identity'];
include_once($_SERVER["DOCUMENT_ROOT"] . "/modules/head.php");
?>

<body>

<?php require 'modules/header.php'; ?>

<main>

    <?=displayResults($connect)?>


</main>

<?php require 'modules/footer.php'; ?>

</body>


</html>