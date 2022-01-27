<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");

if (empty($_SESSION['user']) || empty($_SESSION['user']['id'])) {
    header('Location: index.php');
    exit();
}

function displayAllForm($connect)
{
    $forms = "";
    try {


        $sql = $connect->query("SELECT * FROM Form WHERE id_owner =" . $_SESSION['user']['id'] . " ")->fetchAll();


        foreach ($sql as $value) {

            $forms .=   '<div class="blocFormDashBoard">
                            <div>
                                <a href="visuResults.php?identity=' . $value['id'] . '">
                                    <img src="img/formulaire.png" alt="Prévisualisation">
                                </a> 
                            </div>
                            <div>
                                <p>#' . $value['id'] . '</p>
                                <p> Titre : ' . $value['title'] . '</p>
                                <div>
                                    <a href="CreateForm.php?identity=' . $value['id'] . '">Modifier</a>
                                    <button id="rights-"' . $value['id'] . ' class="buttonRights" type="button">Gérer les droits</button>
                                </div>
                            </div>
                        </div>';
        }
    } catch (PDOException $e) {
        echo 'Erreur sql : (line : ' . $e->getLine() . ") " . $e->getMessage();
    }
    return $forms;
}

function displayProfil()
{
    return "<div>
                <h2>Votre profil</h2> 
                <p> Bonjour : " . $_SESSION['user']['name'] . " - " . $_SESSION['user']['lastname'] . "</p> 
            </div>";
}


function displayUsers($connect)
{
    $ret = "";
    $users = $connect->query("SELECT * FROM User ")->fetchAll();
    foreach ($users as $item) {
        $ret .= ' <label for="' . $item['id'] . '">' . $item['name'] . ' </label>
                  <input class="user-checkb" type="checkbox" name="' . $item['id'] . '" id="' . $item['id'] . '" >';
    }

    return $ret;
}

function displayUsersForEdit($connect)
{
    $ret = "";
    $users = $connect->query("SELECT * FROM User ")->fetchAll();
    foreach ($users as $item) {
        $ret .= ' <label for="' . $item['id'] . '-edit">' . $item['name'] . ' </label>
                  <input class="user-checkb" type="checkbox" name="' . $item['id'] . '-edit" id="' . $item['id'] . '-edit" >';
    }

    return $ret;
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

    <main id="DashBoard">
        <?= displayProfil() ?>

        <div id="dash_board_data">
            <div class="dash_board_part">
                <h2> Consulter les réponses de vos formulaires : </h2> 
                <div id="all-forms">
                    <?= displayAllForm($connect) ?>
                </div>

            </div>

            <div id="list-of-groups"  class="dash_board_part">

                <h2> Consulter vos groupes : </h2> 
                <img id="pannel-group-button" src="img/plus.png" alt="ajouter un groupe">
                <img id="edit-group-button" alt="supprimer un groupe" src="img/edit.svg">
                <div id="all-groups">

                </div>
            </div>
        </div>

        <div id="bgGrey">
            <dialog id="pannel-group">
                <h2>Titre</h2>
                <input type="text" id="title-group" name="title-group">
                <h2>Sélectionner Des utilisteurs</h2>

                <label for="select-all-users">Tout sélectionner</label>
                <input id="select-all-users" type="checkbox" name="select-all-users">

                <?= displayUsers($connect) ?>


                <button id="confirm" type="submit">Confirmer</button>
                <button id="cancel" type="reset">Annuler</button>


            </dialog>

            <dialog id="pannel-edit">

                <h2>Sélectionner un groupe</h2>

                <button id="confirm-delete" type="submit">Supprimer</button>
                <select name="group-select" id="group-select">


                </select>

                <?= displayUsersForEdit($connect) ?>

                <button id="confirm-edit" type="submit">Confirmer</button>
                <button id="cancel-delete" type="reset">Annuler</button>


            </dialog>

            <dialog>

                <h2>Sélectionner un groupe</h2>

                <select name="rights-select" id="rights-select">
                    <option value="none">--Selectionner--</option>
                    <option value="groups">Groupes</option>
                    <option value="users">Utilisateurs</option>

                </select>


                <button id="confirm-rights" type="submit">Confirmer</button>
                <button id="cancel-rights" type="reset">Annuler</button>


            </dialog>
        </div>




    </main>

    <?php require 'modules/footer.php'; ?>

    <script>
        function send(todo) {


            let strSend = tabCheckToString(checkboxs);
            let groupToEdit = document.getElementById("group-select").value;
            let inputTitle = document.getElementById("title-group");
            let titleGroup = inputTitle.value;


            if (groupToEdit === "none" && menuEdit.style.display === "flex") {
                return;
            }


            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById('all-groups').innerHTML = "";
                document.getElementById('group-select').innerHTML = "";

                let $returnString = this.responseText.split("///");

                document.getElementById('all-groups').innerHTML = $returnString[0];
                document.getElementById('group-select').innerHTML = $returnString[1];
                setEventListnerOnMembers()
            }
            xhttp.open("POST", "/asyncGroupe.php");
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send('id-user=' + <?= $_SESSION['user']['id'] ?> + '&tabcheck=' + strSend + '&state-page=' + isArrivedOnPage +
                '&todo=' + todo + '&edited-group=' + groupToEdit + '&title-group=' + titleGroup);
            if (isArrivedOnPage === 0) {
                isArrivedOnPage = 1; //Savoir si on viens d'arriver sur la page ou pas

            }


        }
    </script>

    <script src="js/groupManagement.js"></script>
    <script scr="js/rightsManagement.js"></script>


</body>


</html>