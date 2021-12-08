<!DOCTYPE html>
<html lang="fr">

<?php
$pageName = "UwUniForm";
include_once($_SERVER["DOCUMENT_ROOT"] . "/modules/head.php");
?>

<body id="LogInSignUp">

    <header>
        <!--VIDE-->
    </header>
    <div id="BackgroundAnime"></div>
    <main>



        <form id="form-signin" action="https://ressources.site/" method="post">

            <h2>S'inscrire</h2>

            <div>
                <input id="fname1" type="text" name="fname" autocomplete="off">
                <label for="fname1">Prénom</label>
            </div>

            <div>
                <input id="lname1" type="text" name="lname" autocomplete="off">
                <label for="lname1">Nom</label>
            </div>

            <div>
                <input id="email1" type="email" name="email" autocomplete="off">
                <label for="email1">Email</label>
            </div>

            <div>
                <input id="password1" type="password" name="password" autocomplete="off">
                <label for="password1">Mot de passe</label>
            </div>

            <div>
                <input id="repeat-password" type="password" name="repeat-password" autocomplete="off">
                <label for="repeat-password">Répéter mot de passe</label>
            </div>

            <button id="b-sign-in" type="submit" class="buttonAccueil">S'inscrire</button>

        </form>

        <div id="blocLabel">
            <div id="slidL" class="slider">&laquo;</div>

            <div id="brand" class="noselect">
                <span id="UwU">U<span>w</span>U</span>
                <div>ni</div>
                <div>form</div>
            </div>

            <div id="slidR" class="slider">&raquo;</div>
        </div>

        <form id="form-login" action="/login.php" method="post">

            <h2>Se connecter</h2>

            <div>
                <input id="email2" type="email" name="email" autocomplete="off">
                <label for="email2">Email</label>
            </div>

            <div>
                <input id="password2" type="password" name="password" autocomplete="off">
                <label for="password2">Mot de passe</label>
            </div>

            <button id="b-login" type="submit" class="buttonAccueil">Se connecter</button>

        </form>

    </main>

    <footer>
        <!--VIDE-->
    </footer>

</body>

<script>
    function getRandomInt(max) {
        return Math.floor(Math.random() * max);
    }


    let inputs = document.querySelectorAll('#LogInSignUp main form > div input');

    function inputNotEmpty() {
        let label = document.querySelector('#LogInSignUp main form > div label[for="' + this.id + '"]');
        console.log(label);
        if (this.value != "") {
            label.classList.add('notEmpty');
        } else {
            label.classList.remove('notEmpty');
        }
    }

    for (let index = 0; index < inputs.length; index++) {
        inputs[index].addEventListener('keyup', inputNotEmpty);
    }

    const logo = document.getElementById('UwU');
    let state = 0

    function expression() {
        let value = getRandomInt(5)
        if (value == state) {
            value = (state + 1) % 5;
        }
        state = value;
        switch (value) {
            case 0:
                logo.innerHTML = 'U<span>w</span>U'
                break;

            case 1:
                logo.innerHTML = 'X<span>o</span>X'
                break;

            case 2:
                logo.innerHTML = '^<span>w</span>^'
                break;

            case 3:
                logo.innerHTML = '><span>_</span><'
                break;

            case 4:
                logo.innerHTML = 'O<span>w</span>O'
                break;
        }
    }

    logo.addEventListener('click', expression);
</script>


</html>



<!--
<form class="" action="/exportBdd.php" method="post">

    <button id="submit" type="submit">Enregistrer</button>
        
        
            
</form>

-->