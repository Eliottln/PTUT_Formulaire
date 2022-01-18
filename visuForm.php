<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/modules/vue_form/sendMyResponse.php");

if (empty($_GET['identity'])) {

    if (!empty($_POST)) {
        sendMyResponse($connect, $_POST);
    }

    header("Location: visuAllForms.php");
    exit();
}

$form = new VueForm($connect, $_GET['identity']);

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