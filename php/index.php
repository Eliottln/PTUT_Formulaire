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



                <div class="">

                    <div>
                        <label for="adress">Adresse :</label>
                        <input id="adress" type="text" name="adress" required>
                    </div>

                    <div>
                        <label for="postal">Code postal :</label>
                        <input id="postal" type="text" name="postal" required pattern="[0-9]{5}">
                    </div>

                    <div>
                        <label for="city">Ville :</label>
                        <input id="city" type="text" name="city" required>
                    </div>


                    <div>
                        <label for="surname">Nom :</label>
                        <input id="surname" type="text" name="surname" required>
                    </div>

                </div>
            </div>




            <div class="buttonSR">
                <button type="submit">Envoyer</button>
                <button type="reset">Effacer</button>
            </div>


        </form>
    </body>


</html>