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


        $sql = $connect->query("SELECT * FROM Forms WHERE id_owner =". $_SESSION['user']['id'] ." ")->fetchAll();


        foreach ($sql as $value){

            $forms .=   '<div class="blocArticle">   
                            <p> IdDoc = '. $value['id'].'</p>
                            <a href="visuResults.php?identity='.$value['id'].'">
                                <img style="width: 50px; height: 50px" src="img/formulaire.png" alt="Prévisualisation">
                            </a> 
                            <p> Titre : '. $value['title'] .'</p>
                            <p> Nb Question : '. $value['nb_question'] .'</p>
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
    $users = $connect->query("SELECT * FROM Users ")->fetchAll();
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


</main>

<?php require 'modules/footer.php'; ?>

<script>

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

    function send(){

        let strSend = tabCheckToString(checkbox);

        console.log("changement")
        document.getElementById('all-groups').innerHTML = "";

        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
            document.getElementById('all-groups').innerHTML = this.responseText;
        }
        xhttp.open("POST", "/asyncGroupe.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send('id-user=' + <?= $_SESSION['user']['id']?> + '&tabcheck=' + strSend + '&state-page=' + isArrivedOnPage);
        if(isArrivedOnPage === 0){
            isArrivedOnPage = 1;

        }
        console.log(isArrivedOnPage);


    }

    let checkboxAll = document.getElementById("select-all-users");
    let confirmButton = document.getElementById("confirm");

    displayUserButton = document.getElementById("display-members");
    exitMenuGroupButton = document.getElementById("cancel");

    menuGroup = document.getElementById("pannel-group");
    menuGroupButton = document.getElementById("pannel-group-button");
    checkbox = document.getElementsByClassName("user-checkb");

    state=0;
    isArrivedOnPage = 0;
    checkboxAll.addEventListener('change',selection);
    menuGroupButton.addEventListener('click',displayGroupMenu);
    confirmButton.addEventListener('click', send);
    exitMenuGroupButton.addEventListener('click',exitGroupMenu)

    send();


</script>

</body>


</html>
