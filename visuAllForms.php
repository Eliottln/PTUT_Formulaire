<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");

if (empty($_SESSION['user']) || empty($_SESSION['user']['id'])) {
    header('Location: index.php');
    exit();
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
            <div id="btn-filter" class="btn_view" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-container="body" title="Filtrer les forms">
                <img src="/img/filter_list_white_24dp.svg" alt="filter">
            </div>

            <form class="search" action="/visuAllForms.php" method="get">
                <input type="search" name="search" value="<?= $_GET["search"] ?? NULL ?>" placeholder="Rechercher un titre de form...">
                <button type="submit"><span class="gg-search"></span></button>
            </form>

            <div id="btn-grid-view" class="btn_view" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-container="body" title="Vue Grille">
                <img src="/img/grid_view_white_24dp.svg" alt="grid view">
            </div>

            <div id="btn-list-view" class="btn_view" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Vue Liste">
                <img src="/img/view_list_white_24dp.svg" alt="list view">
            </div>
        </div>

        <div id="filter-panel">
            <form action="" onsubmit="return false">
                <!-- Sort -->
                <div id="divSort">
                    <h3>Trier par...</h3>
                    <div>
                        <select name="sort" id="sort_select">
                            <option value="s1">Titre</option>
                            <option value="s2">Auteur</option>
                            <option value="s3">Progression</option>
                            <option value="s4" selected>Date d'expiration</option>
                        </select>


                        <button id="btn-asc" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-container="body" title="Trie croissant">
                            <img src="/img/sort_white_invert_24dp.svg" alt="ascending">
                        </button>
                        <button id="btn-desc" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-container="body" title="Trie décroissant">
                            <img src="/img/sort_white_24dp.svg" alt="descending">
                        </button>
                    </div>
                </div>

                <!-- Filters -->
                <div id="filters-list">
                    <div>
                        <h3>Ajouter des filtres</h3>
                        <div>
                            <button id="btn-addFilter" type="button">
                                <img src="/img/add_box_white_24dp.svg" alt="add filter">
                            </button>
                            <select name="filter" id="filter_selected">
                                <option value="f0" selected>-----</option>
                                <option value="f1">Titre</option>
                                <option value="f2">Auteur</option>
                                <option value="f3">Progression</option>
                                <option value="f4">Publique</option>
                                <option value="f5">Privé</option>
                            </select>
                        </div>

                        <hr>
                        <div id="div-filters-list">
                            <!-- Filters Here -->
                            
                        </div>

                    </div>
                </div>

                <div>
                    <button id="btn-confirm-filter" type="button">
                        Trier et Filtrer !
                    </button>
                </div>
            </form>
        </div>

        <div id="allFormsDiv" class="displayBloc">
            <!-- All Forms Here -->
        </div>

    </main>


    <?php require 'modules/footer.php'; ?>



    <script src="/js/class_Sort.js"></script>
    <script src="/js/visuAllForms.js"></script>
    <script>
        try {
            let allFormsDiv = document.getElementById('allFormsDiv');
        } catch (error) {
            //console.error("var already exist");
        }

        <?php
        if (isset($_SESSION['formNotFound'])) {
            unset($_SESSION['formNotFound']);
            echo 'alert("le form ' . $_SESSION['formNotFoundID'] . ' n\'est plus accessible")';
            unset($_SESSION['formNotFoundID']);
        }
        ?>

        function getForms() {
            allFormsDiv.innerHTML = ""
            allFormsDiv.appendChild(getWaitingAnimation())

            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                if(this.responseText.length != 0){
                    allFormsDiv.innerHTML = this.responseText;
                }
                else{
                    allFormsDiv.firstChild.innerHTML += '<p class="error-message">FORMS NOT FOUND</p>'
                }
                set()
            }
            xhttp.open("POST", "/asyncAllForms.php");
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send('display=' + viewMode + '&' + sortNFilter.toString() + '&user_id=' + <?= $_SESSION['user']['admin'] . (!empty($_GET['search']) ? " + '&search=" . $_GET['search'] . "'" : null) ?>);
            
        }
        window.addEventListener('load', getForms)

        let btn_confirm = document.getElementById('btn-confirm-filter');
        btn_confirm.addEventListener('click', function(){
            setfilters()
            getForms()
        })

        layoutVisuAllForms()
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script>
        function set() {
            let existToolTips = document.querySelectorAll('div[class^="tooltip "]')
            existToolTips.forEach(element => element.remove())
            let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            let tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        }
        set()
    </script>

</body>


</html>