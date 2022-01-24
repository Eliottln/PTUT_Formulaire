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


function displayCheckboxsQuestions($connect){

    try {
        $ret = "";
        $questions = $connect->query("SELECT id,title
                            FROM Question
                            WHERE id_form = " . $_GET['identity'])->fetchAll();

    }catch(PDOException $e){
        $e->getMessage();
        exit;
    }

    return $ret;
}


function notSorted($connect)
{
    return $connect->query("SELECT Q.title as 'title', U.name || ' ' || U.lastname AS 'name', Result.answer AS 'answer', Result.'update' AS 'date'
                                FROM Result 
                                INNER JOIN User AS U ON U.id = Result.id_user  
                                INNER JOIN Question AS Q ON Q.id = Result.id_question
                                WHERE Result.id_form = " . $_GET['identity'] . " AND Q.id_form = ".$_GET['identity']."
                                ORDER BY Result.'update'")->fetchAll();
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

        <h1>Les résultats du formulaire #<?= $_GET['identity'] ?></h1>

        <label for="filter-question-select">Filtrer</label>

        <div id="list-filters" style="display: flex; flex-direction: column">
            <?=displayCheckboxsQuestions($connect)?>
        </div>



        <section>
            <?php
            /* Petit code en PHP pour formater les informations du CSV */
            ?>
            <div id="chart">

            </div>
        </section>

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


    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        <?php
        $chartCategories = "['";
        $chartData = "[";

        function getSeparator($_data, $value, $quote=null) {

            for ($i=0; $i < count($_data); $i++) { 
                if($_data[count($_data)-1] != $value){
                    return "$quote, $quote";
                }
            }
            return null;
        }

        $_data = $connect->query("SELECT Q.title, COUNT(R.answer) as nbResponse
        FROM Question as Q
        INNER JOIN Result as R
        ON Q.id = R.id_question
        WHERE R.id_form = ".$_GET['identity']." AND Q.id_form = ".$_GET['identity']."
        GROUP by Q.title")->fetchAll();

        foreach ($_data as $value) {
            $chartCategories .= $value['title'] . getSeparator($_data, $value,"'");
            $chartData .= $value['nbResponse'] . getSeparator($_data, $value);
        }


        $chartCategories .= "']";
        $chartData .= "]";
        ?>

        function getAllSerieContent(...ArraySerie){

            function getNameIfExist(name){
                if(name != undefined){
                    return name;
                }
                return null
            }

            let allSerieContent = [];

            for (let index = 0; index < ArraySerie.length; index++) {
                allSerieContent.push({
                    name: getNameIfExist(ArraySerie[index][1]),
                    data: ArraySerie[index][0]
                });
                
            }

            return allSerieContent
        }

        function createChart(ChartTitle, arrayCategories, yAxisTitles, ...ArraySerie) {
            const chart = Highcharts.chart('chart', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: ChartTitle
                },
                xAxis: {
                    categories: arrayCategories
                },
                yAxis: {
                    title: {
                        text: yAxisTitles
                    }
                },
                series: getAllSerieContent(...ArraySerie)
            });
            $('.highcharts-credits')[0].remove();
        }
        document.addEventListener('DOMContentLoaded', createChart('Nombre de réponses par question',
            <?=$chartCategories?>,
            '',
            [<?=$chartData?>,
            'Nombre de réponses']));
    </script>

    <script>
        let asc_desc = 'ASC'
        let sortValue = 'none';

        let sortButton = document.querySelectorAll('[id^="th_"]');
        let filtersCheckBoxs = document.querySelectorAll('[class="checks-filters"]');

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
                if (sortValue == 'name' && asc_desc == 'DESC') {
                    console.log(input)
                    sortValue = 'lastname'
                    input.innerHTML = 'Prénom'
                    input.id = 'th_lastname'
                } else if (sortValue == 'lastname' && asc_desc == 'DESC') {
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
            } else {
                asc_desc == 'ASC'
                input.classList.add('ASC')
            }
            if (sortValue == 'none') {
                input.classList.add('ASC')
            }

        }

        function filtersCheckToString(){
            let tab = document.getElementsByClassName("checks-filters");


            let tabToString = "";
            for(let i =0; i < tab.length; i++){
                let id = tab[i].getAttribute("id").split("-")[2]

                if(tab[i].checked === true){
                    tabToString += id + "/";

                }
            }

            tabToString = tabToString.substring(0,tabToString.length -1);

            console.log(tabToString);

            return tabToString;


        }


        function send() {

            let filtersSelected = filtersCheckToString();

            if (isSortButton(this)) {
                sortButton.forEach(button => button.removeAttribute('class'));
                alreadySelected(this)
                sortValue = this.id.split('_')[1];
            }
            console.log(sortValue);
            console.log(asc_desc)

            //let filter = filterMenu.value;
            let sort = sortValue;
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById('target').innerHTML = "";
                document.getElementById('target').innerHTML = this.responseText.split('||')[0];
            }
            xhttp.open("POST", "/asyncResults.php");
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send('sort=' + sort + '&filter=' + filtersSelected + '&asc_desc=' + asc_desc + '&identity=' + <?= $_GET['identity'] ?>);

        }

        //sortMenu.addEventListener('change', send);
        filtersCheckBoxs.forEach(box => box.addEventListener('change',send))
        sortButton.forEach(button => button.addEventListener('click', send));




    </script>

</body>



</html>
