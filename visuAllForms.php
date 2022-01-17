<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");

if(empty($_SESSION['user']) || empty($_SESSION['user']['id'])){
    header('Location: index.php');
    exit();
}

function displayAllForm($connect): string
{
    $forms = "";
    try {

        $date = $connect->quote(date("Y-m-d"));
        $sql = $connect->query("SELECT * FROM Forms WHERE expire >= ".$date." OR expire = ''")->fetchAll();
        

        foreach ($sql as $value){

            $forms .=   '<div class="blocArticle">   
                            <p> IdDoc = '. $value['id'].'</p>
                            <a href="visuForm.php?identity='.$value['id'].'">
                                <img style="width: 50px; height: 50px" src="img/formulaire.png" alt="Prévisualisation">
                            </a> 
                            <p> Titre : '. $value['title'] .'</p>
                            <p> Nb Question : '. $value['nb_question'] .'</p>
                            <a href="CreateForm.php?identity='.$value['id'].'">Modifier</a>
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

            <?= displayAllForm($connect)?>


        </main>

        <?php require 'modules/footer.php'; ?>

    </body>

    <script>
        <?php
        if (isset($_SESSION['formNotFound'])) {
            unset($_SESSION['formNotFound']);
            echo 'function Success(){alert("le form '.$_SESSION['formNotFoundID'].' n\'est plus accessible")}
                        Success()';
            unset($_SESSION['formNotFoundID']);
        }
        ?>
    </script>


</html>
