<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="utf-8">
    <title>Accueil</title>
    <link type="text/css" rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" sizes="16x16" href="">

</head>

    <body>

        <?php require 'modules/header.php'; ?>

        <main>
            <button type="button" id="new-text">Texte</button>
            <button type="button" id="new-radio">Radio</button>
            <button type="button" id="new-checkbox">Checkbox</button>

            <form id="form-document"  method="post">


            </form>

            <form id="export" action="exportBdd.php" method="post">
                <button id="submit" type="button" >Enregistrer</button>
            </form>
        </main>

        <?php require 'modules/footer.php'; ?>

        <script src="/js/newQuestion.js"></script>
        <script src="/js/transformInputToString.js"></script>

    </body>


</html>