<?php

$title = "Page d'accueil";
require 'header.php';
?>

<body>
        <form class="" action="https://ressources.site/" method="post">

            <div class="">
                <div class="">
                    <div>
                        <label for="email">Adresse mail :</label>
                        <input id="email" type="email" name="email" required>
                    </div>

                    <div>
                        <label for="password">Mot de passe :</label>
                        <input id="password" type="password" name="password" required>
                    </div>

                    <div>
                        <label for="verifpassword">Retaper le mdp :</label>
                        <input id="verifpassword" type="password" name="verifpassword" required>
                    </div>

                    <div>
                        <label for="firstname">Prénom :</label>
                        <input id="firstname" type="text" name="firstname" required>
                    </div>

                </div>
                


            <div class="buttonSR">
                <button type="submit">Envoyer</button>
                <button type="reset">Effacer</button>
            </div>


        </form>
    </body>


</html>