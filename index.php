<!DOCTYPE html>
<html lang="fr">

    <head>

        <meta charset="utf-8">
        <title>Accueil</title>
        <link type="text/css" rel="stylesheet" href="css/style.css">
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
            </div>

                <button id="b-sign-in" type="submit">S'inscrire</button>


            <div id="form-5-text">
                <div>
                    <label for="q5">Question</label>
                    <textarea id="q5" class="question" name="q5" placeholder="Question" required></textarea>
                </div>

                <div>
                    <label for="response-text">Réponse</label>
                    <input id="response-text" type="text" name="response" disabled="">
                </div>
            </div>

            <div id="form-6-radio">
                <div>
                    <label for="q6">Question</label>
                    <textarea id="q6" class="question" name="q6" placeholder="Question" required></textarea>
                </div>

                <div>
                    <p>Réponses</p>
                    <label for="q6-radio1">Choix 1</label>
                    <input id="q6-radio1" type="text" name="q6-radio1">
                    <input type="radio" name="q4-response" disabled="">

                    <label for="q6-radio2">Choix 2</label>
                    <input id="q6-radio2" type="text" name="q6-radio2">
                    <input type="radio" name="q6-response" disabled="">

                    <label for="q6-radio3">Choix 2</label>
                    <input id="q6-radio3" type="text" name="q6-radio3">
                    <input type="radio" name="q6-response" disabled="">

                    <button id="q6-button-add-radio" type="button">Ajouter</button></div>
                </div>
            </div>

            <div id="form-7-checkbox">
                <div>
                    <label for="q7">Question</label>
                    <textarea id="q7" class="question" name="q7" placeholder="Question" required></textarea>
                </div>

                <div>
                    <p>Réponses</p>
                    <label for="q7-checkbox1">Choix 1</label>7
                    <input id="q7-checkbox1" type="text" name="q7-checkbox1">
                    <input type="checkbox" name="q7-response" disabled="">

                    <label for="q7-checkbox2">Choix 2</label>
                    <input id="q7-checkbox2" type="text" name="q7-checkbox2">
                    <input type="checkbox" name="q7-response" disabled="">

                    <label for="q7-checkbox3">Choix 2</label>
                    <input id="q7-checkbox3" type="text" name="q7-checkbox3">
                    <input type="checkbox" name="q7-response" disabled="">

                    <button id="q7-button-add-radio" type="button">Ajouter</button></div>
            </div>
            </div>

            </form>



            <form id="export" action="/exportBdd.php" method="post" >

                <div class="buttonSR">
                    <button  id="submit" type="submit">Enregistrer</button>
                </div>

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



<!--
<form class="" action="/exportBdd.php" method="post">

    <button id="submit" type="submit">Enregistrer</button>
        
        
            
</form>

-->