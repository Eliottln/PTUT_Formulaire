<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/modules/ImportFile.php");
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

        <aside id="palette">
            <div id="tooglePalette">
                <svg width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16.4853 12.0451L12.2426 7.80249L10.8284 9.2167L13.6568 12.0451L10.8284 14.8736L12.2426 16.2878L16.4853 12.0451Z" fill="currentColor" />
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1 4C1 2.34315 2.34315 1 4 1H20C21.6569 1 23 2.34315 23 4V20C23 21.6569 21.6569 23 20 23H4C2.34315 23 1 21.6569 1 20V4ZM4 3H20C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4C3 3.44772 3.44772 3 4 3Z" fill="currentColor" />
                </svg>
            </div>

            <ul>
                <div id="paletteLogo">
                    <svg width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 24C18.6274 24 24 18.6274 24 12C24 5.37258 18.6274 0 12 0C5.37258 0 0 5.37258 0 12C0 18.6274 5.37258 24 12 24ZM18.5793 19.531C20.6758 17.698 22 15.0036 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 14.9616 3.28743 17.6225 5.33317 19.4535L6.99999 10.9738H9.17026L12 6.07251L14.8297 10.9738H17L18.5793 19.531ZM16.0919 21.1272L15.2056 12.9738H8.79438L7.90814 21.1272C9.15715 21.688 10.5421 22 12 22C13.4579 22 14.8428 21.688 16.0919 21.1272Z" fill="currentColor" />
                    </svg>
                </div>
                <li>
                    <form id="addSection" title="add Question">
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
                        <button id="addQuestionButton" type="button">
                            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 6C12.5523 6 13 6.44772 13 7V11H17C17.5523 11 18 11.4477 18 12C18 12.5523 17.5523 13 17 13H13V17C13 17.5523 12.5523 18 12 18C11.4477 18 11 17.5523 11 17V13H7C6.44772 13 6 12.5523 6 12C6 11.4477 6.44772 11 7 11H11V7C11 6.44772 11.4477 6 12 6Z" fill="currentColor" />
                            </svg>
                        </button>
                    </form>
                </li>
                <li>
                    <div id="ClearForm" class="button" title="Reset / New form">Reset Form</div>
                </li>
                <li>
                    <div id="ImportForm" class="button" title="Import form">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 5C11 4.44772 11.4477 4 12 4C12.5523 4 13 4.44772 13 5V12.1578L16.2428 8.91501L17.657 10.3292L12.0001 15.9861L6.34326 10.3292L7.75748 8.91501L11 12.1575V5Z" fill="currentColor" />
                            <path d="M4 14H6V18H18V14H20V18C20 19.1046 19.1046 20 18 20H6C4.89543 20 4 19.1046 4 18V14Z" fill="currentColor" />
                        </svg>
                    </div>
                </li>
            </ul>
            <div id="settings-doc">
                <label id="document-settings-label" for="document-settings">Settings</label>
                <form id="document-settings">
                    <label for="document-title"> Title
                        <input id="document-title" type="text" name="title" placeholder="Form title">
                    </label>
                    <label for="document-layout"> Layout
                        <input id="document-layout" type="range" min="1" max="3" value="1" name="layout">
                    </label>
                </form>

            </div>
        </aside>

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
            <button class="buttonEXPORT" id="submit" type="submit" title="upload to database" disabled>
                <svg width="45" height="45" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 14.9861C11 15.5384 11.4477 15.9861 12 15.9861C12.5523 15.9861 13 15.5384 13 14.9861V7.82831L16.2428 11.0711L17.657 9.65685L12.0001 4L6.34326 9.65685L7.75748 11.0711L11 7.82854V14.9861Z" fill="currentColor" />
                    <path d="M4 14H6V18H18V14H20V18C20 19.1046 19.1046 20 18 20H6C4.89543 20 4 19.1046 4 18V14Z" fill="currentColor" />
                </svg>
            </button>
        </form>

        <form id="document" action="https://ressources.site/" method="post">

        </form>
    </main>

    <?php require 'modules/footer.php'; ?>

    <div class="background">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>

    <script src="/js/newQuestion.js"></script>
    <script src="/js/transformInputToString.js"></script>
    <script src="/js/CreateForm.js"></script>
    <script src="/js/addInputFromObject.js"></script>
    <script>
        <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/modules/createInputFromObject.php"); ?>
    </script>

</body>

</html>