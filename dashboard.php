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
                                    <button id="rights-' . $value['id'] . '" class="button-rights" type="button">Gérer les droits</button>
                                    '.displayButtonsStatus($connect,$value['id']) .'
                                </div>
                            </div>
                        </div>';
        }

    } catch (PDOException $e) {
        echo 'Erreur sql : (line : '. $e->getLine() . ") " . $e->getMessage();

    }
    return $forms;
}

function displayButtonsStatus($connect,$idForm){
    $finalString = "";
    $tabStatus = Array();
    try {
        $status = $connect->query("SELECT status FROM Form WHERE id =". $idForm ." ")->fetch()['status'];

        var_dump($status);
        if($status == "unreferenced"){
            array_push($tabStatus,"block","block","none");
        }else if($status == "public"){
            array_push($tabStatus,"none","block","block");
        }else if($status == "private"){
            array_push($tabStatus,"block","none","block");
        }



        $finalString .= '<a class="button-public" id="public-'. $idForm.'" style="border: 3px solid red; display:'. $tabStatus[0].' " > Publique </a>
                         <a class="button-private" id="private-'. $idForm.'" style="border: 3px solid blue; display:'. $tabStatus[1].' "> Private </a>
                         <a class="button-unreferenced" id="unreferenced-'. $idForm.'" style="border: 3px solid green; display:'. $tabStatus[2].' "> Unreferenced </a>';



    }catch(PDOException $e){
        echo 'Erreur sql : (line : '. $e->getLine() . ") " . $e->getMessage();
    }

    return $finalString;
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
        $ret .= '   <div class="checkboxDialog">
                        <input class="user-checkb" type="checkbox" name="' . $item['id'] . '" id="' . $item['id'] . '" >
                        <label for="' . $item['id'] . '">' . $item['name'] . ' </label>
                    </div>';
    }

    return $ret;

}

function displayUsersForEdit($connect)
{
    $ret = "";
    $users = $connect->query("SELECT * FROM User ")->fetchAll();
    foreach ($users as $item) {
        $ret .= '   <div class="checkboxDialog">
                        <input class="user-checkb" type="checkbox" name="' . $item['id'] . '-edit" id="' . $item['id'] . '-edit" >
                        <label for="' . $item['id'] . '-edit">' . $item['name'] . ' </label>
                    </div>';
    }

    return $ret;
}


function displayUsersForRights($connect){


    $ret = "";
    $users = $connect->query("SELECT * FROM `User` ")->fetchAll();
    foreach ($users as $user) {
        $ret .= '<div style="display: flex; flex-direction: column; margin-right: 10px">
                    <label> '. $user['name'] . '</label>
                    
                    <label for="check-right-u-file-'.$user['id'].'"> Remplir</label>
                    <input class="right-checkbox" type="checkbox" id="check-right-u-file-'.$user['id'].'" name="check-right-u-file-'.$user['id'].'">
                    
                    <label for="check-right-u-modify-'.$user['id'].'"> Modifier</label>
                    <input class="right-checkbox" type="checkbox" id="check-right-u-modify-'.$user['id'].'" name="check-right-u-modify-'.$user['id'].'">
                    
                    <label for="check-right-u-delete-'.$user['id'].'"> Supprimer</label>
                    <input class="right-checkbox" type="checkbox" id="check-right-u-delete-'.$user['id'].'" name="check-right-u-delete-'.$user['id'].'">
                    
                </div>';

    }

    return $ret;
}


function displayGroupsForRights($connect, $user){
    $ret = "";
    $groups = $connect->query("SELECT * FROM `Group` WHERE id_creator = ".$user ."")->fetchAll();
    foreach ($groups as $group){

        $ret .= '<div style="display: flex; flex-direction: column; margin-right: 10px">
                    <label>id: '.$group['id'] .'</label>
                    
                    <label for="check-right-g-file-'.$group['id'] .'">Remplir</label>
                    <input class="right-checkbox" type="checkbox" id="check-right-g-file-'.$group['id'] .'" name="check-right-g-file-'.$group['id'] .'">
                    
                    <label for="check-right-g-modify-'.$group['id'] .'">Modifier</label>
                    <input class="right-checkbox" type="checkbox" id="check-right-g-modify-'.$group['id'] .'" name="check-right-g-modify-'.$group['id'] .'">
                    
                    <label for="check-right-g-delete-'.$group['id'] .'">Supprimer</label>
                    <input class="right-checkbox" type="checkbox" id="check-right-g-delete-'.$group['id'] .'" name="check-right-g-delete-'.$group['id'] .'">
                 </div>';


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

            <div id="list-of-groups" class="dash_board_part">

                <h2> Consulter vos groupes : </h2>
                <img id="pannel-group-button" src="img/plus.png" alt="ajouter un groupe" title="Ajouter un groupe">
                <img id="edit-group-button" alt="modifier/supprimer un groupe" src="img/edit.svg" title="Modifier/supprimer un groupe">
                <hr>
                <div id="all-groups">

                </div>
            </div>
        </div>

        <div id="bgGrey">
            <dialog id="pannel-group">
                <div class="dialog-title">
                    <h2>Ajouter un groupe</h2>
                </div>

                <h3>Titre</h3>
                <input type="text" id="title-group" name="title-group">

                <h3>Sélectionner Des utilisteurs</h3>
                <div id="dash_list-checkbox">
                    <div class="checkboxDialog">
                        <input id="select-all-users" type="checkbox" name="select-all-users">
                        <label for="select-all-users">Tout sélectionner</label>
                    </div>
                </div>

                <?= displayUsersForAdd($connect) ?>


                <div class="dialog-button">
                    <button id="confirm" type="submit">Confirmer</button>
                    <button id="cancel" type="reset">Annuler</button>
                </div>

            </dialog>

            <dialog id="pannel-edit">
                <div class="dialog-title">
                    <h2>Modifier/Supprimer un groupe</h2>
                </div>

                <h3>Sélectionner un groupe</h3>

                <select name="group-select" id="group-select">


                </select>

                <div class="dialog-button">
                    <button id="confirm-delete" type="submit">Supprimer</button>
                </div>

                <?= displayUsersForEdit($connect) ?>

                <div class="dialog-button">
                    <button id="confirm-edit" type="submit">Confirmer</button>
                    <button id="cancel-delete" type="reset">Annuler</button>
                </div>


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


                <button id="confirm-rights" type="submit" style="display: none">Confirmer</button>
                <button id="cancel-rights" type="reset" >Annuler</button>


            </dialog>
        </div>




    </main>

<?php require 'modules/footer.php'; ?>

<script>


    function sendForGroups(_todo){


        let strSend = tabCheckToString(checkboxs);
        let groupToEdit = document.getElementById("group-select").value;
        let inputTitle = document.getElementById("title-group");
        let titleGroup = inputTitle.value;


        if(groupToEdit === "none" && menuEdit.style.display==="flex"){
            return;
        }


        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            document.getElementById('all-groups').innerHTML = "";
            document.getElementById('group-select').innerHTML = "";
            document.getElementById('groups-rights').innerHTML = "";

            let returnString = this.responseText.split("///");

            document.getElementById('all-groups').innerHTML = returnString[0];
            document.getElementById('group-select').innerHTML = returnString[1];
            document.getElementById('groups-rights').innerHTML = returnString[2];
            setEventListnerOnMembers()
        }
        xhttp.open("POST", "/asyncGroupe.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send('id-user=' + <?= $_SESSION['user']['id']?> + '&tabcheck=' + strSend + '&state-page=' + isArrivedOnPage
            + '&todo=' + _todo + '&edited-group=' + groupToEdit + '&title-group=' + titleGroup);
        if(isArrivedOnPage === 0){
            isArrivedOnPage = 1; //Savoir si on viens d'arriver sur la page ou pas

        }


    }

    function sendForRights(){

        let listOfGroups = document.getElementById("groups-rights");
        let listOfUsers = document.getElementById("users-rights");

        if(listOfGroups.style.display === "none" && listOfUsers.style.display === "none" && todoGlobal=="rights"){
            console.log("Pas d'envoie");
            return;
        }

        console.log("Todo --> " + todoGlobal );
        console.log("user ou groupe : " + groupOrUsers);
        //console.log("Le current form : " + idCurrentForm);

        let stringCheck = getCheckedBox();
        console.log("Valeurs des valeurs des check bxox : " + stringCheck);




        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {

            let returnString = this.responseText;
            console.log("Retour de la page asynchrone : "+ returnString);
            switch (returnString){
                case "private":
                    document.getElementById('public-'+idCurrentForm).style.display = "block" ;// public-'. $value['id'].'
                    document.getElementById('private-'+idCurrentForm).style.display = "none";
                    document.getElementById('unreferenced-'+idCurrentForm).style.display = "block";
                    break;

                case "public":
                    document.getElementById('public-'+idCurrentForm).style.display = "none";
                    document.getElementById('private-'+idCurrentForm).style.display = "block";
                    document.getElementById('unreferenced-'+idCurrentForm).style.display = "block";
                    break;

                case "unreferenced":
                    document.getElementById('public-'+idCurrentForm).style.display = "block";
                    document.getElementById('private-'+idCurrentForm).style.display = "block";
                    document.getElementById('unreferenced-'+idCurrentForm).style.display = "none";
                    break;

            }
            //console.log(returnString);


        }
        xhttp.open("POST", "/asyncRights.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhttp.send("id-form=" + idCurrentForm + "&checked-rights="+stringCheck
            + "&todo=" + todoGlobal +"&owner=" + <?= $_SESSION['user']['id']?> +"&group-or-users=" +groupOrUsers);




    }

</script>

<script src="js/groupManagement.js"></script>
<script src="js/rightsManagement.js"></script>


</body>


</html>
