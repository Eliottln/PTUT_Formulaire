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

function notSorted($connect){

    $results = $connect->query("SELECT * FROM Results 
                                INNER JOIN Users AS Tusers      
                                ON Tusers.id = Results.id_user   
                                WHERE Results.id_form = ". $_GET['identity'] . " 
                                ")->fetchAll();

    return $results;

}

function displayResults($connect)
{
    $resultString = "
                     <table id='table-resultats'>
                        <tr>
                            <th>Question</th>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>Réponses</th>
                            
                        </tr>";

    try {

        $results = notSorted($connect);

        foreach($results as $value){

            $question = $connect->query("SELECT title FROM Questions WHERE id_form = ". $_GET['identity'] ." AND id = ". $value['id_question'] ." ")->fetch();
            $resultString .= "<tr> 
                                  <td> ".$question['title'] ." </td> 
                                  <td> ".$value['name'] . "</td>
                                  <td>".$value['lastname'] ."</td>
                                  <td> ".$value['answer'] ."</td>
                              </tr>";

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

    <h2>Les résultats de ce formulaires sont:</h2> <br>

    <select name="pets" id="sort-select">
        <option value="none">--Selectionner un tri--</option>
        <option value="name">Trier par prénom</option>
        <option value="question">Trier par question</option>
        <option value="lastname">Trier par nom de famille</option>

    </select>

    <?=displayResults($connect)?>


</main>

<?php require 'modules/footer.php'; ?>








<script>
    let sortMenu = document.getElementById('sort-select');

    function send(){

        if(sortMenu.value != 'none') {
            document.getElementById('table-resultats').innerHTML = "";


            let sort = sortMenu.value;
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function () {
                document.getElementById('table-resultats').innerHTML = this.responseText;
            }
            xhttp.open("POST", "/asyncResults.php");
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send('sort=' + sort + '&identity=' + <?=$_GET['identity'] ?>);
        }
    }

    sortMenu.addEventListener('change', send);



</script>

</body>


</html>