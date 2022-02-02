<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/modules/export_function/questionAlreadyExistsAndTypeDifferent.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/modules/export_function/deleteResponses.php");


function questionToSQLRequest($pdo, $id, $id_page, $id_form, $id_owner, $type, $title, $required, $min = NULL, $max = NULL, $format = NULL)
{
    if(questionAlreadyExistsAndTypeDifferent($pdo, $id, $id_page, $id_form, $type)){
        //if type is different
        deleteResponses($pdo, $id, $id_page, $id_form);
    }

    //create or modify the question
    $type = $pdo->quote($type);
    $title = $pdo->quote($title);
    $format = $pdo->quote($format);
    switch ($type){
        
        case '\'number\'': 
            return "INSERT OR REPLACE INTO Question(id, id_page, id_form, id_owner, type, title, required, min, max) 
                    VALUES ($id, $id_page, $id_form, $id_owner, $type, $title, $required, $min, $max);";

        case '\'range\'':
        case '\'date\'':
            return "INSERT OR REPLACE INTO Question(id, id_page, id_form, id_owner, type, title, required, format) 
                    VALUES ($id, $id_page, $id_form, $id_owner, $type, $title, $required, $format);";

        default:
            return "INSERT OR REPLACE INTO Question(id, id_page, id_form, id_owner, type, title, required) 
                    VALUES ($id, $id_page, $id_form, $id_owner, $type, $title, $required);";
    }
    
}