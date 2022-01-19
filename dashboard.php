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

    <div>
        <h2> Consulter vos groupes : </h2> <br>
        <img id="pannel-group-button" style="width: 50px; height: 50px" src="img/plus.png" alt="ajouter un groupe">
        <img id="delete-group-button" style="width: 50px; height: 50px" alt="supprimer un groupe" src="img/moins.png">
        <div id="all-groups">

        </div>
    </div>


    <dialog style="display: none" id="pannel-group" >
        <h2>Titre</h2>
        <input type="text" id="title-group" name="title-group">
        <h2>Sélectionner Des utilisteurs</h2>

        <label for="all-users">Tout sélectionner</label>
        <input id="select-all-users" type="checkbox" name="select-all-users">

        <?= displayUsers($connect) ?>


        <button id="confirm" type="submit">Confirmer</button>
        <button id="cancel" type="reset">Annuler</button>


    </dialog>

    <dialog style="display: none" id="pannel-delete" >

        <h2>Sélectionner un groupe</h2>

        <select name="group-select" id="group-select">


        </select>


        <button id="confirm-delete" type="submit">Confirmer</button>
        <button id="cancel-delete" type="reset">Annuler</button>


    </dialog>


</main>

<?php require 'modules/footer.php'; ?>

<script>

    function displayDeleteMenu(){
        menuDelete.style.display = 'flex';
    }

    function exitDeleteMenu(){
        menuDelete.style.display = 'none';
    }

    function displayGroupMenu(){
        menuGroup.style.display = 'flex';
    }

    function exitGroupMenu(){
        menuGroup.style.display = 'none';
    }

    function selectAll(){

        for(let item in checkbox){
            console.log(checkbox[item])
            checkbox[item].checked = true;
        }

    }

    function unselectAll(){
        for(let item in checkbox){
            console.log(checkbox[item])
            checkbox[item].checked = false;
        }
    }

    function selection(){
        this.state = !this.state;

        if(this.state){
            selectAll()
        }else{
            unselectAll()
        }

        console.log(this.state);

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



    function send(todo){
        console.log("todo :::" + todo);
        let strSend = tabCheckToString(checkbox);
        let selectGroup = document.getElementById("group-select");
        let groupToDel = selectGroup.value;

        document.getElementById('all-groups').innerHTML = "";
        document.getElementById('group-select').innerHTML = "";

        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
            let $returnString = this.responseText.split("///");

            document.getElementById('all-groups').innerHTML = $returnString[0];
            document.getElementById('group-select').innerHTML = $returnString[1];
        }
        xhttp.open("POST", "/asyncGroupe.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send('id-user=' + <?= $_SESSION['user']['id']?> + '&tabcheck=' + strSend + '&state-page=' + isArrivedOnPage + '&todo=' + todo + '&deleted-group=' + groupToDel);
        if(isArrivedOnPage === 0){
            isArrivedOnPage = 1;

        }

        console.log("iSarrive ::: "  + isArrivedOnPage);


    }


    let checkboxAll = document.getElementById("select-all-users");
    let confirmButton = document.getElementById("confirm");
    let confirmDeleteButton = document.getElementById("confirm-delete");


    displayUserButton = document.getElementById("display-members");

    menuGroup = document.getElementById("pannel-group");
    menuGroupButton = document.getElementById("pannel-group-button");
    exitMenuGroupButton = document.getElementById("cancel");


    menuDelete = document.getElementById("pannel-delete");
    deleteGroupButton = document.getElementById("delete-group-button");
    exitDeleteGroupButton = document.getElementById("cancel-delete")



    checkbox = document.getElementsByClassName("user-checkb");

    state=0;

    isArrivedOnPage = 0;

    checkboxAll.addEventListener('change',selection);

    menuGroupButton.addEventListener('click',displayGroupMenu);
    exitMenuGroupButton.addEventListener('click',exitGroupMenu)
    confirmButton.addEventListener('click', send.bind(null,"add"));

    confirmDeleteButton.addEventListener('click',send.bind(null,"del"));
    deleteGroupButton.addEventListener('click',displayDeleteMenu)
    exitDeleteGroupButton.addEventListener('click',exitDeleteMenu)




    send("start");


</script>

</body>


</html>
