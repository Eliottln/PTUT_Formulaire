<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");

if (empty($_SESSION['user']) || empty($_SESSION['user']['id'])) {
    header('Location: index.php');
    exit();
}

function displayAllForm($connect): string
{
    $forms = "";
    try {

        $date = $connect->quote(date("Y-m-d"));
        if (!empty($_GET['search'])) {
            $sql = $connect->query("SELECT DISTINCT Form.id,Form.title,Form.nb_page,SUM(Page.nb_question)
            FROM Form INNER JOIN Page ON Page.id_form = Form.id 
            WHERE (expire >= " . $date . " OR expire = '')  AND LOWER(Form.title) LIKE '%" . strtolower($_GET['search']) . "%'
            Group BY Form.id")->fetchAll();
        } else {
            $sql = $connect->query("SELECT DISTINCT Form.id,Form.title,Form.nb_page,SUM(Page.nb_question) 
            FROM Form INNER JOIN Page ON Page.id_form = Form.id 
            WHERE expire >= " . $date . " OR expire = ''
            Group BY Form.id")->fetchAll();
        }


        foreach ($sql as $value) {

            $forms .=   '<div class="blocForm">
                            <div>
                                <a href="/visuForm.php?identity=' . $value['id'] . '">
                                    <p>ID #' . $value['id'] . '</p>
                                    <div>
                                        <img src="img/formulaire.png" alt="image form">
                                    </div>
                                    <p>Titre : ' . $value['title'] . '</p>
                                    <p>' . $value['nb_page'] . ' page' . (($value['nb_page'] > 1) ? "s" : null) . '</p>
                                    <p>' . $value['SUM(Page.nb_question)'] . ' question' . (($value['SUM(Page.nb_question)'] > 1) ? "s" : null) . '</p>
                                </a>
                            </div>
                        </div>';
        }
    } catch (PDOException $e) {
        if (!empty($_SESSION['user']) && $_SESSION['user']['admin'] == 1) {
            echo 'Erreur sql : (line : ' . $e->getLine() . ") " . $e->getMessage();
        } else if (!empty($_SESSION['user']) && $_SESSION['user']['admin'] == 0) {
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

    <main id="visuAll">

        <div>
            <form class="search" action="/visuAllForms.php" method="get">
                <input type="search" name="search" value="<?= $_GET["search"]??NULL ?>">
                <button type="submit"><span class="gg-search"></span></button>
            </form>
        </div>

        <div>
            <?= displayAllForm($connect) ?>
        </div>

    </main>

    <?php require 'modules/footer.php'; ?>

</body>

<script src="/js/class_notification.js"></script>
<script>
    <?php
    if (isset($_SESSION['formNotFound'])) {
        unset($_SESSION['formNotFound']);
        echo 'alert("le form ' . $_SESSION['formNotFoundID'] . ' n\'est plus accessible")';
        unset($_SESSION['formNotFoundID']);
    }
    ?>

    function layoutVisuAllForms() {
        let n = Math.round(window.innerWidth * 2 / 500)
        document.documentElement.style.setProperty('--layoutVisuAllForms', n)
    }

    window.addEventListener('resize', layoutVisuAllForms)
    layoutVisuAllForms()
</script>


</html>