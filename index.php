<!DOCTYPE html>
<html lang="fr" class="reflect">

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



        <form id="form-signin" action="https://ressources.site/" method="post" class="ResponsiveForm">

            <h2>S'inscrire</h2>

            <div>
                <input id="fname1" type="text" name="fname" autocomplete="off" class="ResponsiveInput">
                <label for="fname1">Prénom</label>
            </div>

            <div>
                <input id="lname1" type="text" name="lname" autocomplete="off" class="ResponsiveInput">
                <label for="lname1">Nom</label>
            </div>

            <div>
                <input id="email1" type="email" name="email" autocomplete="off" class="ResponsiveInput">
                <label for="email1">Email</label>
            </div>

            <div>
                <input id="password1" type="password" name="password" autocomplete="off" class="ResponsiveInput">
                <label for="password1">Mot de passe</label>
            </div>

            <div>
                <input id="repeat-password" type="password" name="repeat-password" autocomplete="off" class="ResponsiveInput">
                <label for="repeat-password">Répéter mot de passe</label>
            </div>

            <button id="b-sign-in" type="submit" class="buttonAccueil ResponsiveButton">S'inscrire</button>

        </form>

        <div id="blocLabel">
            <div id="slidL" class="slider">&laquo;</div>

            <div id="brand" class="">
                <img src="/img/logoIndex.png" alt="logo fill n form">
                <div id="menu">
                    <hr>
                    <div id=SignIn>
                        S'inscrire
                    </div>
                    <div id=SignInForm></div>
                    <div id=LogIn>
                        Se connecter
                    </div>
                    <div id=LogInForm></div>
                </div>
            </div>

            <div id="slidR" class="slider">&raquo;</div>
        </div>

        <form id="form-login" action="/login.php" method="post" class="ResponsiveForm">

            <h2>Se connecter</h2>

            <div>
                <input id="email2" type="email" name="email" autocomplete="off" class="ResponsiveInput">
                <label for="email2">Email</label>
            </div>

            <div>
                <input id="password2" type="password" name="password" autocomplete="off" class="ResponsiveInput">
                <label for="password2">Mot de passe</label>
            </div>

            <?php
            //TODO add checkbox remenber-me
            ?>

            <button id="b-login" type="submit" class="buttonAccueil ResponsiveButton">Se connecter</button>

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
        let label = this.parentNode.childNodes[3];
        if (this.value != "") {
            label.classList.add('notEmpty');
        } else {
            label.classList.remove('notEmpty');
        }
    }

    for (let index = 0; index < inputs.length; index++) {
        inputs[index].addEventListener('keyup', inputNotEmpty);
    }



    let main = document.querySelector('#LogInSignUp main');
    let menu = document.getElementById('menu');
    let Msign = document.getElementById('form-signin');
    let Mlog = document.getElementById('form-login');
    let sign = document.getElementById('SignInForm');
    let log = document.getElementById('LogInForm');

    function windowResize() {
        if (window.innerWidth < 1330) {
            menu.style.display = 'flex';
            if (sign.innerHTML == "") {
                let s = Msign.cloneNode(true);
                sign.appendChild(s)
                sign.firstChild.style.display = 'none';
            }
            if (log.innerHTML == "") {
                let l = Mlog.cloneNode(true);
                log.appendChild(l)
                log.firstChild.style.display = 'none';
            }

        } else {
            menu.style.display = 'none';
            if (sign.innerHTML != "" && log.innerHTML != "") {
                sign.innerHTML = log.innerHTML = "";
            }
        }
    }

    windowResize();
    window.addEventListener('resize', windowResize);

    let SignisOpen = false;

    function openSign() {
        if (SignisOpen) {
            sign.firstChild.setAttribute('style', 'display : none;');
            SignisOpen = false;
        } else {
            sign.firstChild.removeAttribute('style');
            SignisOpen = true;
            if (LogisOpen) {
                openLog()
            }
            let inputsSign = document.querySelectorAll('#SignInForm form > div input');
            for (let index = 0; index < inputsSign.length; index++) {
                inputsSign[index].addEventListener('keyup', inputNotEmpty);
            }
        }
    }

    let LogisOpen = false;

    function openLog() {
        if (LogisOpen) {
            log.firstChild.setAttribute('style', 'display : none;');
            LogisOpen = false;
        } else {
            log.firstChild.removeAttribute('style');
            LogisOpen = true;
            if (SignisOpen) {
                openSign()
            }
            let inputsLog = document.querySelectorAll('#LogInForm form > div input');
            for (let index = 0; index < inputsLog.length; index++) {
                inputsLog[index].addEventListener('keyup', inputNotEmpty);
            }
        }
    }

    document.getElementById('SignIn').addEventListener('click', openSign);
    document.getElementById('LogIn').addEventListener('click', openLog);
</script>

</html>