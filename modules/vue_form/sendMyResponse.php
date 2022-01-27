<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/modules/export_function/insert_arrayRequest.php");

function sendMyResponse($pdo, $data, $notLastPage){
    $pdo->beginTransaction();
    try {
        $all_result = array();
        $yourID = $_SESSION['user']['id'];
        $page = $_GET['page']-1;
        $formID = $data['formID'];
        $ownerID = $data['ownerID'];


        $id_question = $pdo->query("SELECT min(id)
                                    FROM Question
                                    WHERE id_page = ".$page." AND id_form = ".$formID)->fetchColumn();
        $data = array_slice($data, 2);

        $date = date('Y-m-d H:i:s');

        foreach ($data as $value){
            
            if(is_array($value)){
                $s = "";
                foreach ($value as $response){
                    $s .= $response;
                    if($response != $value[count($value)-1]){
                        $s .= ', ';
                    }
                }
                $value = $s;
            }
            $sql = 'INSERT OR REPLACE INTO Result VALUES ('.$yourID.', '.$page.', '.$id_question.', '.$formID .', '.$ownerID.', "'.$value.'", "'.$date.'");';
            array_push($all_result, $sql);
            $id_question++;
        }
        
        
        

        if(!empty($all_result)){
            insert_arrayRequest($pdo, $all_result);
        }

        $pdo->commit();
        
        $_SESSION['nb_question'] = $id_question;

        if(!$notLastPage){
            unset($_SESSION['nb_question']);
            unset($_SESSION['page']);
        }
        
    } catch (\Throwable $th) {
        $pdo->rollback();
        echo 'Erreur sql : (line : '. $th->getLine() . ") " . $th->getMessage();
    }
}