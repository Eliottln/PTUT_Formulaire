<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");
foreach (glob($_SERVER["DOCUMENT_ROOT"] . "/modules/vue_form/*.php") as $filename) {
    include $filename;
}

if (empty($_GET['identity'])) {

    header("Location: dashboard.php");
    exit();
}

function fileSelectQuestion($connect)
{
    $ret = $connect->query("SELECT id,title
                            FROM Question
                            WHERE id_form = " . $_GET['identity'] . "
                            GROUP BY title")->fetchAll();

    $stringRet = "";
    foreach ($ret as $value) {
        $stringRet .= "<option value=" . $value['id'] . "> " . $value['title'] . "</option>";
    }

    return $stringRet;
}

function notSorted($connect)
{

    $results = $connect->query("SELECT Q.title as 'title', U.name || ' ' || U.lastname AS 'name', Result.answer AS 'answer', Result.'update' AS 'date'
                                FROM Result 
                                INNER JOIN User AS U ON U.id = Result.id_user  
                                INNER JOIN Question AS Q ON Q.id = Result.id_question
                                WHERE Result.id_form = " . $_GET['identity'] . "
                                ORDER BY Result.'update'")->fetchAll();

    return $results;
}

function displayResults($connect)
{
    $resultString = "";
    try {

        $results = notSorted($connect);

        foreach ($results as $value) {


            $resultString .= "<tr> 
                                  <td> " . $value['title'] . " </td> 
                                  <td> " . $value['name'] . "</td>
                                  <td>" . $value['answer'] . "</td>
                                  <td> " . $value['date'] . "</td>
                              </tr>";
        }
    } catch (PDOException $e) {
        echo 'Erreur sql : (line : ' . $e->getLine() . ") " . $e->getMessage();
    }

    return $resultString;
}

?>

<!DOCTYPE html>
<html lang="fr">

<?php
$pageName = "Resultats " . $_GET['identity'];
include_once($_SERVER["DOCUMENT_ROOT"] . "/modules/head.php");
?>

<body>

    <?php require 'modules/header.php'; ?>

    <main id="visuResults">

        <h1>Les résultats du formulaire <?= $_GET['identity']?></h1>

        <label for="filter-question-select">Filtrer</label>
        <select name="filter-question" id="filter-question-select">
            <option value="none">--Pas de filtre--</option>
            <?= fileSelectQuestion($connect) ?>


        </select>

        <table id='table-resultats'>
            <thead>
                <tr>
                    <th id="th_question">Question</th>
                    <th id="th_name">Nom</th>
                    <th id="th_response">Réponses</th>
                    <th id="th_date">Date</th>
                </tr>
            </thead>
            <tbody id="target">
                <?= displayResults($connect) ?>
            </tbody>
        </table>

    </main>

    <?php require 'modules/footer.php'; ?>





    <script>
        let asc_desc = 'ASC'
        let sortValue = 'none';

        let filterMenu = document.getElementById('filter-question-select')
        let sortButton = document.querySelectorAll('[id^="th_"]');

        function isSortButton(input) {
            for (let index = 0; index < sortButton.length; index++) {
                if (sortButton[index] == input) {
                    return true;
                }
            }
            return false;
        }

        function alreadySelected(input) {
            if ((input.id.split('_')[1] == sortValue) && (sortValue != 'none')) {
                
                // name change into lastname and vice versa
                if(sortValue == 'name' && asc_desc == 'DESC'){
                    console.log(input)
                    sortValue = 'lastname'
                    input.innerHTML = 'Prénom'
                    input.id = 'th_lastname'
                }
                else if(sortValue == 'lastname' && asc_desc == 'DESC'){
                    sortValue = 'name'
                    input.innerHTML = 'Nom'
                    input.id = 'th_name'
                }

                switch (asc_desc) {
                    case 'ASC':
                        asc_desc = 'DESC'
                        input.classList.add('DESC')
                        break;
                    case 'DESC':
                        asc_desc = 'ASC'
                        input.classList.add('ASC')
                        break;
                }
            }
            else{
                asc_desc == 'ASC'
                input.classList.add('ASC')
            }
            if(sortValue == 'none') {
                input.classList.add('ASC')
            }

        }

        function send() {

            

            if (isSortButton(this)) {
                sortButton.forEach(button => button.removeAttribute('class'));
                alreadySelected(this)
                sortValue = this.id.split('_')[1];
            }
            console.log(sortValue);
                console.log(asc_desc)

            let filter = filterMenu.value;
            let sort = sortValue;
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById('target').innerHTML = "";
                document.getElementById('target').innerHTML = this.responseText;
            }
            xhttp.open("POST", "/asyncResults.php");
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send('sort=' + sort + '&filter=' + filter + '&asc_desc=' + asc_desc + '&identity=' + <?= $_GET['identity'] ?>);

        }

        //sortMenu.addEventListener('change', send);
        filterMenu.addEventListener('change', send);
        sortButton.forEach(button => button.addEventListener('click', send));
    </script>

</body>


</html>