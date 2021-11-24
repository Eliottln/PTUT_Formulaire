
<html>

    <body>
        <form id="form-document" action="/exportBdd.php" method="post">

            <div id="form-1-text">
                <div>
                    <label for="q1">Question</label>
                    <textarea id="q1" class="question" name="q1" placeholder="Question" required></textarea>
                </div>

                <div>
                    <label for="response-text">Réponse</label>
                    <input id="response-text" type="text" name="response" disabled="">
                </div>
            </div>

            <div id="form-2-text">
                <div>
                    <label for="q2">Question</label>
                    <textarea id="q2" class="question" name="q2" placeholder="Question" required></textarea>
                </div>

                <div>
                    <label for="response-text">Réponse</label>
                    <input id="response-text" type="text" name="response" disabled="">
                </div>
            </div>



            <div id="form-3-text">
                <div>
                    <label for="q3">Question</label>
                    <textarea id="q3" class="question" name="q3" placeholder="Question" required></textarea>
                </div>

                <div>
                    <label for="response-text">Réponse</label>
                    <input id="response-text" type="text" name="response" disabled="">
                </div>
            </div>


            <div id="form-4-radio">
                <div>
                    <label for="q4">Question</label>
                    <textarea id="q4" class="question" name="q4" placeholder="Question" required></textarea>
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
                    <label for="q6-radio-choice1">Choix 1</label>
                    <input id="q6-radio-choice1" type="text" name="q6-radio-choice1">
                    <input type="radio" name="q4-response" disabled="">

                    <label for="q6-radio-choice2">Choix 2</label>
                    <input id="q6-radio-choice2" type="text" name="q6-radio-choice2">
                    <input type="radio" name="q6-response" disabled="">

                    <label for="q6-radio-choice3">Choix 2</label>
                    <input id="q6-radio-choice3" type="text" name="q6-radio-choice3">
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
                    <label for="q7-checkbox-choice1">Choix 1</label>7
                    <input id="q7-checkbox-choice1" type="text" name="q7-checkbox-choice1">
                    <input type="checkbox" name="q7-response" disabled="">

                    <label for="q7-checkbox-choice2">Choix 2</label>
                    <input id="q7-checkbox-choice2" type="text" name="q7-checkbox-choice2">
                    <input type="checkbox" name="q7-response" disabled="">

                    <label for="q7-checkbox-choice3">Choix 2</label>
                    <input id="q7-checkbox-choice3" type="text" name="q7-checkbox-choice3">
                    <input type="checkbox" name="q7-response" disabled="">

                    <button id="q7-button-add-radio" type="button">Ajouter</button></div>
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