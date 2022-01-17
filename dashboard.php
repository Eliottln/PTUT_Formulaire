<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");

if(empty($_SESSION['user']) || empty($_SESSION['user']['id'])){
    header('Location: index.php');
    exit();
}

function displayAllForm($connect){
    $forms = "<h2> Consulter les réponses de vos formulaires : </h2> <br>";
    try {

        $date = $connect->quote(date("Y-m-d"));

        $sql = $connect->query("SELECT * FROM Forms WHERE id_owner =". $_SESSION['user']['id'] ." ")->fetchAll();


        foreach ($sql as $value){

            $forms .=   '<div class="blocArticle">   
                            <p> IdDoc = '. $value['id'].'</p>
                            <a href="visuResults.php?identity='.$value['id'].'">
                                <img style="width: 50px; height: 50px" src="img/formulaire.png" alt="Prévisualisation">
                            </a> 
                            <p> Titre : '. $value['title'] .'</p>
                            <p> Nb Question : '. $value['nb_question'] .'</p>
                        </div>';
        }

    } catch (PDOException $e) {
        if(!empty($_SESSION['user']) && $_SESSION['user']['admin'] == 1){
            echo 'Erreur sql : (line : '. $e->getLine() . ") " . $e->getMessage();
        }
        else if(!empty($_SESSION['user']) && $_SESSION['user']['admin'] == 0){
            echo 'Il semblerait que les formulaires ne sont pas accessible';
        }

    }
    return $forms;
}

function displayProfil(){
    $profil = " <div>
                    <h2>Votre profil</h2> <br>
                    <p> Bonjour : " . $_SESSION['user']['name'] . " - ". $_SESSION['user']['lastname'] ."</p> <br>
                </div>";

    return $profil;
}


?>


<!DOCTYPE html>
<html lang="fr">

<?php
$pageName = "Tous les Forms";
include_once($_SERVER["DOCUMENT_ROOT"] . "/modules/head.php");
?>

<body>

<?php require 'modules/header.php'; ?>

<main>
    <?= displayProfil() ?>
    <?= displayAllForm($connect)?>


</main>

<?php require 'modules/footer.php'; ?>

</body>


</html>
