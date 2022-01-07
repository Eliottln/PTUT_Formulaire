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

        <div id="togglePalette">
            <svg width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M16.4853 12.0451L12.2426 7.80249L10.8284 9.2167L13.6568 12.0451L10.8284 14.8736L12.2426 16.2878L16.4853 12.0451Z" fill="currentColor" />
                <path fill-rule="evenodd" clip-rule="evenodd" d="M1 4C1 2.34315 2.34315 1 4 1H20C21.6569 1 23 2.34315 23 4V20C23 21.6569 21.6569 23 20 23H4C2.34315 23 1 21.6569 1 20V4ZM4 3H20C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4C3 3.44772 3.44772 3 4 3Z" fill="currentColor" />
            </svg>
        </div>

        <aside id="palette">

            <ul>
                <li>
                    <div id="AdvancedSettings" class="button" title="Advanced settings">AS</div>
                </li>
                <li>
                    <div id="ClearForm" class="button" title="Reset / New form">Reset Form</div>
                </li>
                <hr>
                <li>
                    <form id="addSection">
                        <button type="button" id="new-checkbox" value="new-checkbox" title="checkbox">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.2426 16.3137L6 12.071L7.41421 10.6568L10.2426 13.4853L15.8995 7.8284L17.3137 9.24262L10.2426 16.3137Z" fill="currentColor" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1 5C1 2.79086 2.79086 1 5 1H19C21.2091 1 23 2.79086 23 5V19C23 21.2091 21.2091 23 19 23H5C2.79086 23 1 21.2091 1 19V5ZM5 3H19C20.1046 3 21 3.89543 21 5V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V5C3 3.89543 3.89543 3 5 3Z" fill="currentColor" />
                            </svg>
                        </button>
                        <button type="button" id="new-color" value="new-color" title="color">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.20348 2.00378C9.46407 2.00378 10.5067 3.10742 10.6786 4.54241L19.1622 13.0259L11.384 20.8041C10.2124 21.9757 8.31291 21.9757 7.14134 20.8041L2.8987 16.5615C1.72713 15.3899 1.72713 13.4904 2.8987 12.3188L5.70348 9.51404V4.96099C5.70348 3.32777 6.82277 2.00378 8.20348 2.00378ZM8.70348 4.96099V6.51404L7.70348 7.51404V4.96099C7.70348 4.63435 7.92734 4.36955 8.20348 4.36955C8.47963 4.36955 8.70348 4.63435 8.70348 4.96099ZM8.70348 10.8754V9.34247L4.31291 13.733C3.92239 14.1236 3.92239 14.7567 4.31291 15.1473L8.55555 19.3899C8.94608 19.7804 9.57924 19.7804 9.96977 19.3899L16.3337 13.0259L10.7035 7.39569V10.8754C10.7035 10.9184 10.7027 10.9612 10.7012 11.0038H8.69168C8.69941 10.9625 8.70348 10.9195 8.70348 10.8754Z" fill="currentColor" />
                                <path d="M16.8586 16.8749C15.687 18.0465 15.687 19.946 16.8586 21.1175C18.0302 22.2891 19.9297 22.2891 21.1013 21.1175C22.2728 19.946 22.2728 18.0465 21.1013 16.8749L18.9799 14.7536L16.8586 16.8749Z" fill="currentColor" />
                            </svg>
                        </button>
                        <button type="button" id="new-date" value="new-date" title="date">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 13C7.44772 13 7 12.5523 7 12C7 11.4477 7.44772 11 8 11C8.55228 11 9 11.4477 9 12C9 12.5523 8.55228 13 8 13Z" fill="currentColor" />
                                <path d="M8 17C7.44772 17 7 16.5523 7 16C7 15.4477 7.44772 15 8 15C8.55228 15 9 15.4477 9 16C9 16.5523 8.55228 17 8 17Z" fill="currentColor" />
                                <path d="M11 16C11 16.5523 11.4477 17 12 17C12.5523 17 13 16.5523 13 16C13 15.4477 12.5523 15 12 15C11.4477 15 11 15.4477 11 16Z" fill="currentColor" />
                                <path d="M16 17C15.4477 17 15 16.5523 15 16C15 15.4477 15.4477 15 16 15C16.5523 15 17 15.4477 17 16C17 16.5523 16.5523 17 16 17Z" fill="currentColor" />
                                <path d="M11 12C11 12.5523 11.4477 13 12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12Z" fill="currentColor" />
                                <path d="M16 13C15.4477 13 15 12.5523 15 12C15 11.4477 15.4477 11 16 11C16.5523 11 17 11.4477 17 12C17 12.5523 16.5523 13 16 13Z" fill="currentColor" />
                                <path d="M8 7C7.44772 7 7 7.44772 7 8C7 8.55228 7.44772 9 8 9H16C16.5523 9 17 8.55228 17 8C17 7.44772 16.5523 7 16 7H8Z" fill="currentColor" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6 3C4.34315 3 3 4.34315 3 6V18C3 19.6569 4.34315 21 6 21H18C19.6569 21 21 19.6569 21 18V6C21 4.34315 19.6569 3 18 3H6ZM18 5H6C5.44772 5 5 5.44772 5 6V18C5 18.5523 5.44772 19 6 19H18C18.5523 19 19 18.5523 19 18V6C19 5.44772 18.5523 5 18 5Z" fill="currentColor" />
                            </svg>
                        </button>
                        <button type="button" id="new-email" value="new-email" title="email">@</button>
                        <button type="button" id="new-number" value="new-number" title="number">1</button>
                        <button type="button" id="new-radio" value="new-radio" title="radio">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16Z" fill="currentColor" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM20 12C20 16.4183 16.4183 20 12 20C7.58172 20 4 16.4183 4 12C4 7.58172 7.58172 4 12 4C16.4183 4 20 7.58172 20 12Z" fill="currentColor" />
                            </svg>
                        </button>
                        <button type="button" id="new-range" value="new-range" title="range">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="3" y="10" width="18" height="4" rx="2" fill="currentColor" />
                                <rect x="0" y="10" width="10" height="4" rx="2" fill="currentColor" />
                            </svg>
                        </button>
                        <button type="button" id="new-select" value="new-select" title="select">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.17154 11.508L7.75732 10.0938L12 5.85113L16.2426 10.0938L14.8284 11.508L12 8.67956L9.17154 11.508Z" fill="currentColor" />
                                <path d="M9.17154 12.492L7.75732 13.9062L12 18.1489L16.2426 13.9062L14.8284 12.492L12 15.3204L9.17154 12.492Z" fill="currentColor" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1 5C1 2.79086 2.79086 1 5 1H19C21.2091 1 23 2.79086 23 5V19C23 21.2091 21.2091 23 19 23H5C2.79086 23 1 21.2091 1 19V5ZM5 3H19C20.1046 3 21 3.89543 21 5V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V5C3 3.89543 3.89543 3 5 3Z" fill="currentColor" />
                            </svg>
                        </button>
                        <button type="button" id="new-tel" value="new-tel" title="tel">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 10V5C2 4.44775 2.44772 4 3 4H8C8.55228 4 9 4.44775 9 5V9C9 9.55225 8.55228 10 8 10H6C6 14.4182 9.58173 18 14 18V16C14 15.4478 14.4477 15 15 15H19C19.5523 15 20 15.4478 20 16V21C20 21.5522 19.5523 22 19 22H14C7.37259 22 2 16.6274 2 10Z" fill="currentColor" />
                            </svg>
                        </button>
                        <button type="button" id="new-text" value="new-text" title="text">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.5 3H3V6.5H4V4H6.5V3Z" fill="currentColor" />
                                <path d="M8.5 4V3H11V4H8.5Z" fill="currentColor" />
                                <path d="M13 4H15.5V3H13V4Z" fill="currentColor" />
                                <path d="M17.5 3V4H20V6.5H21V3H17.5Z" fill="currentColor" />
                                <path d="M21 8.5H20V11H21V8.5Z" fill="currentColor" />
                                <path d="M21 13H20V15.5H21V13Z" fill="currentColor" />
                                <path d="M21 17.5H20V20H17.5V21H21V17.5Z" fill="currentColor" />
                                <path d="M15.5 21V20H13V21H15.5Z" fill="currentColor" />
                                <path d="M11 21V20H8.5V21H11Z" fill="currentColor" />
                                <path d="M6.5 21V20H4V17.5H3V21H6.5Z" fill="currentColor" />
                                <path d="M3 15.5H4V13H3V15.5Z" fill="currentColor" />
                                <path d="M3 11H4V8.5H3V11Z" fill="currentColor" />
                                <path d="M11 9.5H7V7.5H17V9.5H13V16.5H11V9.5Z" fill="currentColor" />
                            </svg>
                        </button>
                        <button type="button" id="new-url" value="new-url" title="url">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8 4V8H4V10H8V14H4V16H8V20H10V16H14V20H16V16H20V14H16V10H20V8H16V4H14V8H10V4H8ZM14 14V10H10V14H14Z" fill="currentColor" />
                            </svg>
                        </button>
                        <button type="button" id="new-file" value="new-file" title="file">File</button>
                    </form>
                </li>
                <hr>
                <li>
                    <div id="ImportForm" class="button" title="Import form">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 5C11 4.44772 11.4477 4 12 4C12.5523 4 13 4.44772 13 5V12.1578L16.2428 8.91501L17.657 10.3292L12.0001 15.9861L6.34326 10.3292L7.75748 8.91501L11 12.1575V5Z" fill="currentColor" />
                            <path d="M4 14H6V18H18V14H20V18C20 19.1046 19.1046 20 18 20H6C4.89543 20 4 19.1046 4 18V14Z" fill="currentColor" />
                        </svg>
                    </div>
                </li>
            </ul>
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

            <dialog id="settings-doc">
                <label id="document-settings-label" for="document-settings">Settings</label>
                <form id="document-settings">
                    <label for="d"> Title
                        <input id="d" type="text" name="title" placeholder="Form title">
                    </label>
                    <label for="document-layout"> Layout
                        <input id="document-layout" type="range" min="1" max="3" value="1" name="layout">
                    </label>
                    <button id="confirmAS" type="button">Confirmer</button>
                    <button id="cancelAS" type="reset">Annuler</button>
                </form>

            </dialog>
        </div>

        <form id="export" action="exportBdd.php" method="post">
            <button class="buttonEXPORT" id="submit" type="button" title="upload to database" disabled>
                <svg width="45" height="45" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 14.9861C11 15.5384 11.4477 15.9861 12 15.9861C12.5523 15.9861 13 15.5384 13 14.9861V7.82831L16.2428 11.0711L17.657 9.65685L12.0001 4L6.34326 9.65685L7.75748 11.0711L11 7.82854V14.9861Z" fill="currentColor" />
                    <path d="M4 14H6V18H18V14H20V18C20 19.1046 19.1046 20 18 20H6C4.89543 20 4 19.1046 4 18V14Z" fill="currentColor" />
                </svg>
            </button>
        </form>

        <form id="document" action="https://ressources.site/" method="post">
            <div><label>Titre : </label><input type="text" name="title" id="document-title"></div>
            <div id="form-content"></div>
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

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#document" ).sortable();
        } );
    </script>

    <script src="/js/newQuestion.js"></script>
    <script src="/js/transformInputToString.js"></script>
    <script src="/js/CreateForm.js"></script>
    <script src="/js/addInputFromObject.js"></script>
    <script>
        <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/modules/createInputFromObject.php"); ?>
    </script>

</body>

</html>