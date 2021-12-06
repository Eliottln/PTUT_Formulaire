<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <title>Accueil</title>
    <link type="text/css" rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" sizes="16x16" href="">

</head>

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

        <form id="form-login" action="/login.php" method="get">

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
</script>


</html>