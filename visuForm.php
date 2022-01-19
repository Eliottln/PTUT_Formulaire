<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/modules/vue_form/sendMyResponse.php");

if (empty($_GET['identity'])) {

    header("Location: visuAllForms.php");
    exit();
} else if (empty($_GET['page'])) {
    $_GET['page'] = 1;
}

$form = new VueForm($connect, $_GET['identity'], $_GET['page']);

if (!empty($_POST)) {
    $notLastPage = !empty(($_GET['page'] - 1) < $form->getNBPage());
    sendMyResponse($connect, $_POST,$notLastPage);

    if ($notLastPage) {
        header("Location: visuForm.php?identity=" . $_GET['identity'] . "&page=" . $_GET['page']);
        exit();
    } else {
        header("Location: visuAllForms.php");
        exit();
    }
}

//!!! GIGA LOURD !!!
if ($form->getError()) {
    $_SESSION['formNotFound'] = true;
    $_SESSION['formNotFoundID'] = $_GET['identity'];
    header("Location: visuAllForms.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">

<?php
$pageName = "Form " . $_GET['identity'];
include_once($_SERVER["DOCUMENT_ROOT"] . "/modules/head.php");
?>

<body>

    <?php require 'modules/header.php'; ?>

    <main id="VisuForm">

        <a class="buttonBack" href="/visuAllForms.php">&laquo; retour vers tous les forms</a>

        <div id="page">

            <div>
                <h1><?= '#' . $form->getID() ?></h1>
            </div>

            <div>
                <h2><?= $form->getTitle() ?></h2>
            </div>

            <div>
                <h3><?= 'by ' . $form->getOwner() ?></h3>
            </div>

            <?= $form->toString() ?>

        </div>

    </main>

    <?php require 'modules/footer.php'; ?>

</body>
<script>
    function rangeCounter(id) {
        console.log(id);
        let value = document.getElementById(id).value;
        document.getElementById(id + "-counter").innerHTML = value;
    }
    document.querySelectorAll("input[type='range']").forEach(
        range => range.addEventListener("change", rangeCounter.bind(
            null, range.id))
    );
</script>

</html>