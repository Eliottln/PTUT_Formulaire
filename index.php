
<html>

    <body>
            <form class="" action="/exportBdd.php" method="post">

                <div>
                    <label for="q1">Question 1</label>
                    <input id="q1" type="text" name="q1" required>
                </div>

                <div>
                    <label for="q2">Question 2</label>
                    <input id="q2" type="text" name="q2" required>
                </div>

                <div>
                    <label for="q3">Question 3</label>
                    <input id="q3" type="text" name="q3" required>
                </div>

                <div>
                    <label for="q4">Question 4</label>
                    <input id="q4" type="text" name="q4" required>
                </div>

                <div>
                    <label for="q5">Question 5</label>
                    <input id="q5" type="password" name="q5" required>
                </div>

                <div>
                    <label for="q6">Question 6</label>
                    <input id="q6" type="password" name="q6" required>
                </div>


            </form>



            <form id="export" action="/exportBdd.php" method="post" >

                <div class="buttonSR">
                    <button  id="submit" type="submit">Enregistrer</button>
                </div>

            </form>





        <script src="js/transformInputToString.js" >  </script>
        </body>


</html>