
<?php


include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");
foreach (glob($_SERVER["DOCUMENT_ROOT"] . "/modules/vue_form/*.php") as $filename) {
    include $filename;
}

function selectTypeOfSort( $sort,$connect,$idForm, $filter='none'){


    switch ($sort){
        case 'name':
            $results = sortByName($connect,$idForm,$filter);
            break;

        case 'question':
            $results = sortByQuestion($connect,$idForm,$filter);
            break;

        case 'lastname':
            $results = sortByLastName($connect,$idForm,$filter);
            break;

        case 'none':
            //PASSE ICI SEULEMENT LORSQUE SORT EST EGAL A 'none' CAR IL YA DEJA UNE CONDITION DANS visuResults
            $results = notSorted($connect, $idForm, $filter);
            break;

    }

    return $results;

}

function notSorted($connect, $idForm, $filter = 'none'){
    $results = $connect->query("SELECT * FROM Results 
                                INNER JOIN Users AS Tusers      
                                ON Tusers.id = Results.id_user   
                                WHERE Results.id_form = ".$idForm." ". (($filter!='none')? "AND Results.id_question=".$filter : "" )."
                                ")->fetchAll();

    return $results;
}

function sortByName($connect,$idForm, $filter = 'none'){

        $results = $connect->query("SELECT * FROM Results 
                                INNER JOIN Users AS Tusers      
                                ON Tusers.id = Results.id_user   
                                WHERE Results.id_form = ".$idForm." ". (($filter!='none')? "AND Results.id_question=".$filter : "" )." 
                                ORDER BY UPPER(Tusers.name) ASC
                                ")->fetchAll();

        return $results;


}

function sortByQuestion($connect,$idForm, $filter = 'none'){

    $results = $connect->query("SELECT * FROM Results 
                            INNER JOIN Users AS Tusers      
                            ON Tusers.id = Results.id_user   
                            WHERE Results.id_form = ".$idForm." ". (($filter!='none')? "AND Results.id_question=".$filter : "" )." 
                            ORDER BY Results.id_question ASC
                            ")->fetchAll();

    return $results;


}

function sortByLastName($connect, $idForm, $filter='none'){
    $results = $connect->query("SELECT * FROM Results 
                                INNER JOIN Users AS Tusers      
                                ON Tusers.id = Results.id_user   
                                WHERE Results.id_form = ".$idForm." ". (($filter!='none')? "AND Results.id_question=".$filter : "" )." 
                                ORDER BY UPPER(Tusers.lastname) ASC
                                ")->fetchAll();

    return $results;
}


function displayResults($connect,$idForm,$sort, $filter='none' ){
    $resultString = "
                        <tr>
                            <th>Question</th>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>Réponses</th>
                            
                        </tr>";

    try {

        $results = selectTypeOfSort($sort,$connect,$idForm,$filter);


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
$filter = $_POST["filter"];


$finalString = displayResults($connect,$idForm,$sort,$filter);

echo $finalString;