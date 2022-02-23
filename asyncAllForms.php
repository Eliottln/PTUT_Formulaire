<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");

//Query
function query($connect,$user_id,$search=null)
{
    // get user progress

    try {
        $date = $connect->quote(date("Y-m-d"));
    if (!empty($search)) {
        $query = $connect->query(getSQL_AllForms_Search($date,$user_id,$search))->fetchAll();
    } else {
        $query = $connect->query(getSQL_AllForms($date,$user_id))->fetchAll();
    }
    } catch (\Throwable $th) {
        //throw $th;
        $query = [];
    }
    

    return $query;
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
    if($format === 'column'){
        //...
    }
    else{
        foreach ($query as $value) {

            $allFormsString .=   '<div class="blocForm">
                                    <div>
                                        <a href="/visuForm.php?identity=' . $value['id'] . '">
                                            <div>
                                                ' . getProgress($value) . '
                                                <p>' . $value['title'] . '</p>
                                            </div>
                                            
                                            <div>
                                                <img src="img/formulaire.png" alt="image form">
                                            </div>
                                            <p class="formID">by ' . $value['name'] . '</p>' .
                                            (!empty($value['expire']) ? '<p>expire le ' . $value['expire'] ?? NULL . '</p>' : NULL). '
                                            <p>' . $value['nb_page'] . ' page' . (($value['nb_page'] > 1) ? "s" : null) . '</p>
                                            <p>' . $value['nb_question'] . ' question' . (($value['nb_question'] > 1) ? "s" : null) . '</p>
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
$display = $_POST["display"];  // bloc/column
$user_id = $_POST["user_id"];
$search = $_POST["search"]??null;

$query = query($connect,$user_id,$search);

if(!empty($query)){
    $result = formatHtml($display,$query);
}

echo $result??"";