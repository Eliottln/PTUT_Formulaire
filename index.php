<!DOCTYPE html>
<html lang="fr">

    <head>

        <meta charset="utf-8">
        <title>Accueil</title>
        <link type="text/css" rel="stylesheet" href="">
        <link rel="icon" type="image/png" sizes="16x16" href="">

    </head>

    <body>

        <?php require 'modules/header.php'; ?>

        <main>

            <form id="form-signin" action="https://ressources.site/" method="post">

                <div>
                    <input id="fname1" type="text" name="fname1">
                    <label for="fname1">Prénom</label>
                </div>

                <div>
                    <input id="lname1" type="text" name="lname1">
                    <label for="lname1">Nom</label>
                </div>

                <div>
                    <input id="email1" type="email" name="email1">
                    <label for="email1">Email</label>
                </div>

                <div>
                    <input id="password1" type="password" name="password1">
                    <label for="password1">Mot de passe</label>
                </div>

                <div>
                    <input id="repeat-password" type="password" name="repeat-password">
                    <label for="repeat-password">Répéter mot de passe</label>
                </div>

                <button id="b-sign-in" type="submit">S'inscrire</button>

            </form>

            <form id="form-login" action="https://ressources.site/" method="post">

                <div>
                    <input id="email2" type="email" name="email2">
                    <label for="email2">Email</label>
                </div>

                <div>
                    <input id="password2" type="password" name="password2">
                    <label for="password2">Mot de passe</label>
                </div>

                <button id="b-login" type="submit">Se connecter</button>

            </form>

        </main>

        <?php require 'modules/footer.php'; ?>

    </body>

</html>