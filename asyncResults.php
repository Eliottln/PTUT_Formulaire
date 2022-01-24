
<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");

function selectTypeOfSort($sort, $connect, $_SQL_REQUEST, $asc_desc)
{

    switch ($sort) {
        case 'name':
            $results = sortByName($connect, $_SQL_REQUEST, $asc_desc);
            break;

        case 'date':
            $results = sortByDate($connect, $_SQL_REQUEST, $asc_desc);
            break;

        case 'response':
            $results = sortByResponse($connect, $_SQL_REQUEST, $asc_desc);
            break;

        case 'question':
            $results = sortByQuestion($connect, $_SQL_REQUEST, $asc_desc);
            break;

        case 'lastname':
            $results = sortByLastName($connect, $_SQL_REQUEST, $asc_desc);
            break;

        case 'none':
        default:
            //PASSE ICI SEULEMENT LORSQUE SORT EST EGAL A 'none' CAR IL YA DEJA UNE CONDITION DANS visuResults
            $results = notSorted($connect, $_SQL_REQUEST);
            break;
    }
    return $results;
}

function notSorted($connect, $_SQL_REQUEST)
{

    return $connect->query($_SQL_REQUEST)->fetchAll();
}

function sortByLastName($connect, $_SQL_REQUEST, $asc_desc)
{

    return $connect->query($_SQL_REQUEST . " ORDER BY UPPER(U.name) " . $asc_desc)->fetchAll();
}

function sortByDate($connect, $_SQL_REQUEST, $asc_desc)
{

    return $connect->query($_SQL_REQUEST . " ORDER BY UPPER(Result.'update') " . $asc_desc)->fetchAll();
}

function sortByResponse($connect, $_SQL_REQUEST, $asc_desc)
{

    return $connect->query($_SQL_REQUEST . " ORDER BY UPPER(Result.answer) " . $asc_desc)->fetchAll();
}

function sortByQuestion($connect, $_SQL_REQUEST, $asc_desc)
{

    return $connect->query($_SQL_REQUEST . " ORDER BY UPPER(Result.id_question) " . $asc_desc)->fetchAll();
}

function sortByName($connect, $_SQL_REQUEST, $asc_desc)
{

    return $connect->query($_SQL_REQUEST . " ORDER BY UPPER(U.lastname) " . $asc_desc)->fetchAll();
}

function filtersStringToSql($filters){
    $tabFilters =  Array();
    $parsing = explode("/",$filters);
    $sqlRequest = "AND (Result.id_question=" . $parsing[0] . " ";

    for($i=1; $i < count($parsing); $i++){
        $sqlRequest .= "OR Result.id_question=" . $parsing[$i] . " " ;
    }

    $sqlRequest .= ")";
    return $sqlRequest;
}


function displayResults($connect, $sort, $_SQL_REQUEST, $asc_desc)
{
    $resultString = "";

    try {

        $results = selectTypeOfSort($sort, $connect, $_SQL_REQUEST, $asc_desc);

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



//--------------MAIN-------------------

$sort = $_POST["sort"];
$idForm = $_POST["identity"];
$filters = ($_POST["filter"]=='')?'none':$_POST["filter"];
$asc_desc = $_POST["asc_desc"];

$sqlRequestFilters = filtersStringToSql($filters);


define("_SQL_REQUEST", "SELECT Q.title as 'title', U.name || ' ' || U.lastname AS 'name', Result.answer AS 'answer', Result.'update' AS 'date'
                        FROM Result 
                        INNER JOIN User AS U ON U.id = Result.id_user  
                        INNER JOIN Question AS Q ON Q.id = Result.id_question
                        WHERE Result.id_form = " . $idForm . " AND Q.id_form = ". $idForm ." " . (($filters != 'none') ? $sqlRequestFilters : NULL));


$finalString = displayResults($connect, $sort, _SQL_REQUEST, $asc_desc);
//TODO send chart data
$chartCategories = "";
$chartData = "";

echo $finalString . '||' . $chartCategories . '||' . $chartData;

