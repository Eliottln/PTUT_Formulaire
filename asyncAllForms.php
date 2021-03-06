<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");

//Query
function query($connect,$user_id,$sort,$asc_desc,$filter,$search=null)
{
    // get user progress

    try {
        $date = $connect->quote(date("Y-m-d"));
        $query = $connect->query(getSQL_AllForms($date,$user_id,$sort,$asc_desc,$filter,$search))->fetchAll();
        //echo getSQL_AllForms($date,$user_id,$sort,$asc_desc,$filter,$search);
    } catch (\Throwable $th) {
        throw $th;
        $query = [];
    }
    

    return $query;
}

function getTextInfo($data){
    $res = $data['nb_response'] / $data['nb_question'];
    if($res == 0){
        $progress = 'Pas de réponse';
    }
    elseif($res > 0 && $res < 1){
        $progress = $data['nb_response'] ." sur ". $data['nb_question'].' réponse'.(($data['nb_question']>1?"s":null));
    }
    else{
        $progress = 'Toutes les réponses sont complétées';
    }

    return 
        '<strong>Progression : </strong>'.$progress. '<br>'.
        '<strong>Créé par : </strong>'.$data['name']. '<br>'.
        '<strong>Expire le : </strong>'.(empty($data['expire'])?'jamais':$data['expire']).  '<br>'.
        '<strong>Nombre de pages : </strong>'.$data['nb_page']. '<br>'.
        '<strong>Nombre de questions : </strong>'.$data['nb_question']
    ;
}

function getProgress($data){
    $res = $data['nb_response'] / $data['nb_question'];
    
    if($res == 0){
        return '<img src="/img/empty_circle.svg" alt="empty_circle">';
    }
    elseif($res > 0 && $res < 1){
        return '<img src="/img/incomplete_circle.svg" alt="incomplete_circle">';
    }
    else{
        return '<img src="/img/complete_circle.svg" alt="complete_circle">';
    }
}

// Formatting
function formatHTML($format, $query)
{
    $allFormsString = "";
    if($format === 'list'){
        foreach ($query as $value) {

            $allFormsString .=   '<div class="blocListForm">
                                    <div data-bs-toggle="tooltip" data-bs-placement="auto" data-bs-container="body" data-bs-html="true" title="'.getTextInfo($value).'">
                                        <a href="/visuForm.php?identity=' . $value['id'] . '">
                                            <div>
                                                ' . getProgress($value) . '
                                                <p>|</p>
                                                <p>' . $value['title'] . '</p>
                                                <p>|</p>
                                                <p class="formID">Créé par ' . $value['name'] . '</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>';
        }
    }
    else{
        foreach ($query as $value) {

            $allFormsString .=   '<div class=" blocForm">
                                    <div data-bs-toggle="tooltip" data-bs-placement="auto" data-bs-container="body" data-bs-html="true" title="'.getTextInfo($value).'">
                                        <a href="/visuForm.php?identity=' . $value['id'] . '">
                                            <div>
                                                ' . getProgress($value) . '
                                                <p>' . $value['title'] . '</p>
                                            </div>
                                            
                                            <div>
                                                <img src="img/formulaire.png" alt="image form">
                                            </div>
                                            <p class="formID">Créé par ' . $value['name'] . '</p>
                                        </a>
                                    </div>
                                </div>';
        }
    }
    
    return $allFormsString;
}


/**
 * Main
 * 
 */
$display = $_POST["display"];  //  grid/column
$user_id = $_POST["user_id"];
$sort = $_POST["sort"];
$asc_desc = $_POST["asc_desc"];
$filter = $_POST["filter"];
$search = $_POST["search"]??null;

$query = query($connect,$user_id,$sort,$asc_desc,$filter,$search);

if(!empty($query)){
    $result = formatHtml($display,$query);
}

echo $result??"";