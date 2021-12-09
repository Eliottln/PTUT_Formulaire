<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/include/config.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/modules/ImportFile.php");
?>


<!DOCTYPE html>
<html lang="fr">


<?php
$pageName = "Createur de Formulaires";
include_once($_SERVER["DOCUMENT_ROOT"] . "/modules/head.php");
?>

<body>

    <?php require 'modules/header.php'; ?>

    <main>

        <div id="palette">

            <ul>
                <li>
                    <div id="addSection" class="button">Ajouter une question</div>
                    <div id="choose-type">
                        <form >
                            <select name="addQuestion" id="addQuestion">
                                <option id="new-checkbox" value="new-checkbox">Checkbox</option>
                                <option id="new-color" value="new-color" disabled>Color</option>
                                <option id="new-date" value="new-date">Date</option>
                                <option id="new-email" value="new-email" disabled>Email</option>
                                <option id="new-number" value="new-number" disabled>Number</option>
                                <option id="new-radio" value="new-radio">Radio</option>
                                <option id="new-range" value="new-range" disabled>Range</option>
                                <option id="new-select" value="new-select" disabled>Select</option>
                                <option id="new-tel" value="new-tel" disabled>Tel</option>
                                <option id="new-text" value="new-text">Texte</option>
                                <option id="new-url" value="new-url" disabled>Url</option>
                            </select>
                            <a id="buttonTYPE" class="button" disabled>Ajouter</a>
                        </form>
                    </div>
                </li>
                <li>
                    <div id="ClearForm" class="button">Recommencer</div>
                </li>
                <li>
                    <div id="ImportForm" class="button">Importer un formulaire</div>
                </li>
            </ul>
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
            <button class="buttonEXPORT" id="submit" type="submit" disabled>Enregistrer</button>
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

        function styleHTLM(){
            let html = document.documentElement;
            html.classList.add('randonBG');
            document.getElementsByTagName('header')[0].setAttribute('style',"z-index: 2");
            document.getElementById('palette').setAttribute('style',"z-index: 2");
        }

        styleHTLM();
    </script>

</body>

</html>