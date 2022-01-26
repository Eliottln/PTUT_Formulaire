<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");

if(empty($_SESSION['user']) || empty($_SESSION['user']['id'])){
    header('Location: index.php');
    exit();
}

function displayAllForm($connect){
    $forms ="";
    try {


        $sql = $connect->query("SELECT * FROM Form WHERE id_owner =". $_SESSION['user']['id'] ." ")->fetchAll();


        foreach ($sql as $value){

            $forms .=   '<div class="blocArticle">   
                            <p> IdDoc = '. $value['id'].'</p>
                            <a href="visuResults.php?identity='.$value['id'].'">
                                <img style="width: 50px; height: 50px" src="img/formulaire.png" alt="Prévisualisation">
                            </a> 
                            <p> Titre : '. $value['title'] .'</p>
                            <a href="CreateForm.php?identity=' . $value['id'] . '">Modifier</a>
                            <button id="rights-'.$value['id'] .'" class="buttonRights" type="button">Gérer les droits</button>
                        </div>';
        }

    } catch (PDOException $e) {
        echo 'Erreur sql : (line : '. $e->getLine() . ") " . $e->getMessage();

    }
    return $forms;
}

function displayProfil(){
    $profil = " <div>
                    <h2>Votre profil</h2> <br>
                    <p> Bonjour : " . $_SESSION['user']['name'] . " - ". $_SESSION['user']['lastname'] ."</p> <br>
                </div>";

    return $profil;
}


function displayUsersForAdd($connect){
    $ret = "";
    $users = $connect->query("SELECT * FROM User ")->fetchAll();
    foreach ($users as $item) {
        $ret .= ' <label for="'. $item['id'] .'">'. $item['name'] . ' </label>
                  <input class="user-checkb" type="checkbox" name="'. $item['id'] .'" id="'. $item['id'] .'" >';
    }

    return $ret;

}

function displayUsersForEdit($connect){
    $ret = "";
    $users = $connect->query("SELECT * FROM User ")->fetchAll();
    foreach ($users as $item) {
        $ret .= ' <label for="'. $item['id'] .'-edit">'. $item['name'] . ' </label>
                  <input class="user-checkb" type="checkbox" name="'. $item['id'] .'-edit" id="'. $item['id'] .'-edit" >';
    }

    return $ret;
}


function displayUsersForRights($connect){


    $ret = "";
    $users = $connect->query("SELECT * FROM `User` ")->fetchAll();
    foreach ($users as $user) {
        $ret .= '<div style="display: flex; flex-direction: column; margin-right: 10px">
                    <label> '. $user['name'] . '</label>
                    
                    <label for="check-right-file-'.$user['id'].'"> Remplir</label>
                    <input class="right-checkbox" type="checkbox" id="check-right-file-'.$user['id'].'" name="check-right-file-'.$user['id'].'">
                    
                    <label for="check-right-modify-'.$user['id'].'"> Modifier</label>
                    <input class="right-checkbox" type="checkbox" id="check-right-modify-'.$user['id'].'" name="check-right-modify-'.$user['id'].'">
                    
                    <label for="check-right-delete-'.$user['id'].'"> Supprimer</label>
                    <input class="right-checkbox" type="checkbox" id="check-right-delete-'.$user['id'].'" name="check-right-delete-'.$user['id'].'">
                    
                </div>';

    }

    return $ret;
}


function displayGroupsForRights($connect, $user){
    $ret = "";
    $groups = $connect->query("SELECT * FROM `Group` WHERE id_creator = ".$user ."")->fetchAll();
    foreach ($groups as $group){

        //$ret .= "<div>

        //         </div>";

        $ret .= "Group : " . $group['title'] . " id = " . $group['id'] . "<br>";
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

<main>
    <?= displayProfil() ?>
    <div>
        <h2> Consulter les réponses de vos formulaires : </h2> <br>
        <div id="all-forms">
            <?= displayAllForm($connect)?>
        </div>

    </div>

    <div id="list-of-groups">

        <h2> Consulter vos groupes : </h2> <br>
        <img id="pannel-group-button" style="width: 50px; height: 50px" src="img/plus.png" alt="ajouter un groupe">
        <img id="edit-group-button" style="width: 50px; height: 50px" alt="supprimer un groupe" src="img/edit.svg">
        <div id="all-groups">

        </div>
    </div>

    <div id="bgGrey">
        <dialog style="display: none"  id="pannel-group" >
            <h2>Titre</h2>
            <input type="text" id="title-group" name="title-group">
            <h2>Sélectionner Des utilisteurs</h2>

            <label for="select-all-users">Tout sélectionner</label>
            <input id="select-all-users" type="checkbox" name="select-all-users">

            <?= displayUsersForAdd($connect) ?>


            <button id="confirm" type="submit">Confirmer</button>
            <button id="cancel" type="reset">Annuler</button>


        </dialog>

        <dialog style="display: none " id="pannel-edit" >

            <h2>Sélectionner un groupe</h2>

            <button id="confirm-delete" type="submit">Supprimer</button>
            <select name="group-select" id="group-select">


            </select>

            <?= displayUsersForEdit($connect) ?>

            <button id="confirm-edit" type="submit">Confirmer</button>
            <button id="cancel-delete" type="reset">Annuler</button>


        </dialog>

        <dialog style="display: none " id="pannel-rights">

            <h2>Sélectionner un groupe</h2>


            <a style="border: 2px solid white"  id="show-users-rights">Utilisateurs</a>
            <a style="border: 2px solid white"  id="show-groups-rights">Groupes</a>

            <div id="groups-rights" style="display: none">
                <?= displayGroupsForRights($connect,$_SESSION['user']['id'])?>
            </div>

            <div id="users-rights" style="display: none">

                <?= displayUsersForRights($connect)?>
            </div>

            <div id="checkboxs-rights">
            </div>


            <button id="confirm-rights" type="submit">Confirmer</button>
            <button id="cancel-rights" type="reset">Annuler</button>


        </dialog>
    </div>




</main>

<?php require 'modules/footer.php'; ?>

<script>


    function sendForGroups(todo){


        let strSend = tabCheckToString(checkboxs);
        let groupToEdit = document.getElementById("group-select").value;
        let inputTitle = document.getElementById("title-group");
        let titleGroup = inputTitle.value;


        if(groupToEdit === "none" && menuEdit.style.display==="flex"){
            return;
        }


        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
            document.getElementById('all-groups').innerHTML = "";
            document.getElementById('group-select').innerHTML = "";

            let returnString = this.responseText.split("///");

            document.getElementById('all-groups').innerHTML = returnString[0];
            document.getElementById('group-select').innerHTML = returnString[1];
            setEventListnerOnMembers()
        }
        xhttp.open("POST", "/asyncGroupe.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send('id-user=' + <?= $_SESSION['user']['id']?> + '&tabcheck=' + strSend + '&state-page=' + isArrivedOnPage
            + '&todo=' + todo + '&edited-group=' + groupToEdit + '&title-group=' + titleGroup);
        if(isArrivedOnPage === 0){
            isArrivedOnPage = 1; //Savoir si on viens d'arriver sur la page ou pas

        }


    }

    function sendForRights(){


        //let idForm = document.getElementById()
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
            //Faire le remplissage ici
            let returnString = this.responseText.split("///");
            console.log(returnString);
            document.getElementById("users-rights").innerHTML = "";
            document.getElementById("groups-rights").innerHTML = "";

            document.getElementById("users-rights").innerHTML = returnString;
            document.getElementById("groups-rights").innerHTML = returnString;





        }
        xhttp.open("POST", "/asyncRights.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id-form=" + idCurrentForm);//Envoyer les données ici

    }

</script> 

<script src="js/groupManagement.js"></script>
<script src="js/rightsManagement.js"></script>


</body>


</html>
