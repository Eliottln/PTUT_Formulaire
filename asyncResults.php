
<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");
foreach (glob($_SERVER["DOCUMENT_ROOT"] . "/modules/vue_form/*.php") as $filename) {
    include $filename;
}

function selectTypeOfSort( $sort,$connect,$idForm){


    switch ($sort){
        case 'name':
            $results = sortByName($connect,$idForm);
            break;

        case 'question':
            $results = sortByQuestion($connect,$idForm);
            break;

    }

    return $results;

}

function sortByName($connect,$idForm){

    $results = $connect->query("SELECT * FROM Results 
                                INNER JOIN Users AS Tusers      
                                ON Tusers.id = Results.id_user   
                                WHERE Results.id_form = ".$idForm ."
                                ORDER BY Tusers.name ASC
                                ")->fetchAll();

    return $results;
}

function sortByQuestion($connect,$idForm){
    $results = $connect->query("SELECT * FROM Results 
                                INNER JOIN Users AS Tusers      
                                ON Tusers.id = Results.id_user   
                                WHERE Results.id_form = ".$idForm ."
                                ORDER BY Results.id_question ASC
                                ")->fetchAll();

    return $results;
}

function displayResults($connect,$idForm,$sort){
    $resultString = "
                        <tr>
                            <th>Question</th>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>Réponses</th>
                            
                        </tr>";

    try {

        $results = selectTypeOfSort($sort,$connect,$idForm);
        //$results = sortByName($connect,$idForm);

        foreach($results as $value){

            $question = $connect->query("SELECT title FROM Questions WHERE id_form = ".$idForm." AND id = ". $value['id_question'] ." ")->fetch();
            $resultString .= "<tr> 
                                  <td> ".$question['title'] ." </td> 
                                  <td> ".$value['name'] . "</td>
                                  <td>".$value['lastname'] ."</td>
                                  <td> ".$value['answer'] ."</td>
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


echo displayResults($connect,$idForm,$sort);