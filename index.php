
<html>

    <body>
        <form class="" action="/exportBdd.php" method="post">

            <div id="form1-text">
                <div>
                    <label for="q1">Question</label>
                    <textarea id="q1" class="question" name="q1" placeholder="Question" required=""></textarea>
                </div>

                <div>
                    <label for="response-text">Réponse</label>
                    <input id="response-text" type="text" name="response" disabled="">
                </div>
            </div>

            <div id="form2-text">
                <div>
                    <label for="q2">Question</label>
                    <textarea id="q2" class="question" name="q2" placeholder="Question" required=""></textarea>
                </div>

                <div>
                    <label for="response-text">Réponse</label>
                    <input id="response-text" type="text" name="response" disabled="">
                </div>
            </div>

            <div id="form3-text">
                <div>
                    <label for="q3">Question</label>
                    <textarea id="q3" class="question" name="q3" placeholder="Question" required=""></textarea>
                </div>

                <div>
                    <label for="response-text">Réponse</label>
                    <input id="response-text" type="text" name="response" disabled="">
                </div>
            </div>


            <div id="form4-radio">
                <div>
                    <label for="q4">Question</label>
                    <textarea id="q4" class="question" name="q4" placeholder="Question" required=""></textarea>
                </div>

                <div>
                    <p>Réponses</p>
                    <label for="q4-radio-choice1">Choix 1</label>
                    <input id="q4-radio-choice1" type="text" name="q4-radio-choice1">
                    <input type="radio" name="q4-response" disabled="">

                    <label for="q4-radio-choice2">Choix 2</label>
                    <input id="q4-radio-choice2" type="text" name="q4-radio-choice2">
                    <input type="radio" name="q4-response" disabled="">
                    
                    <button id="q4-button-add-radio" type="button">Ajouter</button></div>
                </div>
            </div>



            </form>



            <form id="export" action="/exportBdd.php" method="post" >

                <div class="buttonSR">
                    <button  id="submit" type="button">Enregistrer</button>
                </div>

            </form>


        <script src="js/transformInputToString.js" >  </script>
        </body>


</html>



<!--
<form class="" action="/exportBdd.php" method="post">

    <button id="submit" type="submit">Enregistrer</button>
        
        
            
</form>

-->