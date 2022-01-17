<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/modules/export_function/insert_arrayRequest.php");

function sendMyResponse($pdo, $data){
    $pdo->beginTransaction();
    try {
        $all_result = array();
        $yourID = $_SESSION['user']['id'];
        $formID = $data['formID'];
        $ownerID = $data['ownerID'];
        $data = array_slice($data, 2);

        foreach ($data as $key => $value){
            
            if(is_array($value)){
                $s = "";
                foreach ($value as $response){
                    $s .= $response . ', ';
                }
                $value = $s;
            }
            $sql = 'INSERT OR REPLACE INTO Results VALUES ('.$yourID.', '.explode('-',$key)[1].', '.$formID .', '.$ownerID.', "'.$value.'");';
            array_push($all_result, $sql);
        }
        //$sth = $pdo->prepare("INSERT");


        if(!empty($all_result)){
            insert_arrayRequest($pdo, $all_result);
        }

        $pdo->commit();
        
    } catch (\Throwable $th) {
        $pdo->rollback();
        echo 'Erreur sql : (line : '. $th->getLine() . ") " . $th->getMessage();
    }
}