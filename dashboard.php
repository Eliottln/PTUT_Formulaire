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


function displayUsers($connect){
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


    <dialog style="display: none"  id="pannel-group" >
        <h2>Titre</h2>
        <input type="text" id="title-group" name="title-group">
        <h2>Sélectionner Des utilisteurs</h2>

        <label for="select-all-users">Tout sélectionner</label>
        <input id="select-all-users" type="checkbox" name="select-all-users">

        <?= displayUsers($connect) ?>


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




</main>

<?php require 'modules/footer.php'; ?>

<script>


    function displayMembersOfGroup(group){
        let liste = document.getElementById("liste-"+group);
        liste.style.display = "flex";
    }

    function hideMembersOfGroup(group){
        let liste = document.getElementById("liste-"+group);
        liste.style.display = "none";
    }

    function displayDeleteMenu(){
        menuEdit.style.display = 'flex';

    }

    function exitDeleteMenu(){
        menuEdit.style.display = 'none';

        for(let i =0 ; i < checkboxs.length; i++){
            checkboxs[i].checked = false;
        }
    }


    function displayGroupMenu(){
        menuGroup.style.display = 'flex';

    }

    function exitGroupMenu(){
        menuGroup.style.display = 'none';

        for(let i =0 ; i < checkboxs.length; i++){

            checkboxs[i].checked = false;
        }
    }

    function selectAll(){

        for(let i =0; i < checkboxs.length/2; i++){

            checkboxs[i].checked = true;
        }


    }

    function unselectAll(){
        for(let item in checkboxs){

            checkboxs[item].checked = false;
        }
    }

    function selection(){
        this.state = !this.state;

        if(this.state){
            selectAll()
        }else{
            unselectAll()
        }



    }

    function tabCheckToString(tabCheck){
        let ret = "";

        for(let i=0; i < tabCheck.length; i++){

            if(tabCheck[i].checked === true) {
                if (i === tabCheck.length - 1)
                    ret += tabCheck[i].id;

                else {
                    ret += tabCheck[i].id + "/";
                }
            }

        }

        console.log(ret);
        return ret;
    }


    function setEventListnerOnMembers(){

        let imgOfGroups = document.getElementsByClassName("img-of-group");

        for(let i = 0; i< imgOfGroups.length; i++){

            imgOfGroups[i].addEventListener('click',showMembers)

        }
    }

    function showMembers(){

        let id = "list-of-" + this.getAttribute("id").split("-")[2];

        let list = document.getElementById(id);

        if(list.style.display === "flex")
            list.style.display = "none";
        else
            list.style.display = "flex";

    }

    function send(todo){


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

            let $returnString = this.responseText.split("///");

            document.getElementById('all-groups').innerHTML = $returnString[0];
            document.getElementById('group-select').innerHTML = $returnString[1];
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

    checkboxs = document.getElementsByClassName("user-checkb"); //toutes les checkbox

    let checkboxAll = document.getElementById("select-all-users");
    let confirmButton = document.getElementById("confirm"); //Ajouter



    menuGroup = document.getElementById("pannel-group");
    let menuGroupButton = document.getElementById("pannel-group-button");
    let exitMenuGroupButton = document.getElementById("cancel");


    menuEdit = document.getElementById("pannel-edit");
    let editGroupButton = document.getElementById("edit-group-button");
    let exitEditGroupButton = document.getElementById("cancel-delete")
    let confirmEditButton = document.getElementById("confirm-edit") // Modifier
    let confirmDeleteButton = document.getElementById("confirm-delete"); //Supprimer




    checkboxAll.addEventListener('change',selection); //La checkbox pour tout sélectionner

    menuGroupButton.addEventListener('click',displayGroupMenu);
    exitMenuGroupButton.addEventListener('click',exitGroupMenu)
    confirmButton.addEventListener('click', send.bind(null,"add"));

    confirmDeleteButton.addEventListener('click',send.bind(null,"del"));
    editGroupButton.addEventListener('click',displayDeleteMenu);
    exitEditGroupButton.addEventListener('click',exitDeleteMenu);
    confirmEditButton.addEventListener('click',send.bind(null,"modify"));

    state=0;
    isArrivedOnPage = 0;

    send("start");









</script>


</body>


</html>
