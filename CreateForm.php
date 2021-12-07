<?php
    echo "<pre id=\"debug\"><code>";
    include_once($_SERVER["DOCUMENT_ROOT"]."/modules/ImportFile.php");
    echo "</code></pre>";
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Createur de Formulaires</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>

    <?php require 'modules/header.php'; ?>

    <main>

        <div id="palette">

            <ul>
                <li>
                    <div id="addSection" class="button">Ajouter une question</div>
                    <div id="choose-type">
                        <ul>
                            <li>
                                <div id="new-text" class="subButton">Texte</div>
                            </li>
                            <li>
                                <div id="new-radio" class="subButton">Radio</div>
                            </li>
                            <li>
                                <div id="new-checkbox" class="subButton">Checkbox</div>
                            </li>
                            <li>
                                <div id="new-date" class="subButton">Date</div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <div id="ClearForm" class="button">Recommencer</div>
                </li>
                <li>
                    <div id="ImportForm" class="button">Importer un formulaire</div>
                </li>
            </ul>

            <div id="Debug-button" class="button">&#128421;Debug</div>
        </div>

        <div id="bgGrey">
            <dialog id="Import">
                <form action="CreateForm.php" method="post">
                    <input type="file" name="importedFile" id="file">

                    <input type="hidden" name="fileToString" id="fileToString">
                    <input type="hidden" name="fileType" id="fileType">

                    <button id="confirm" type="submit" disabled>Confirmer</button>
                    <button id="cancel" type="reset">Annuler</button>
                </form>
                <pre>
                    <label id="typeofFile"></label>
                    <code id="output-code"></code>
                </pre>
            </dialog>
        </div>

        <form id="export" action="exportBdd.php" method="post">
            <button id="submit" type="submit" disabled>Enregistrer</button>
        </form>

        <form id="document" action="https://ressources.site/" method="post">

        </form>
    </main>

    <?php require 'modules/footer.php'; ?>

    <script src="/js/newQuestion.js"></script>
    <script src="/js/transformInputToString.js"></script>
    <script src="/js/CreateForm.js"></script>
    <script src="/js/addInputFromObject.js"></script>
    <script>
        <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/modules/createInputFromObject.php"); ?>
    </script>

</body>

</html>