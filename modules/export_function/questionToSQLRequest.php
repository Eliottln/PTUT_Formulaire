<?php

function questionToSQLRequest($pdo, $id, $id_form, $id_owner, $type, $title = "", $required = 0, $min = NULL, $max = NULL, $format = NULL)
{
    $type = $pdo->quote($type);
    $title = $pdo->quote($title);
    $format = $pdo->quote($format);
    switch ($type){
        case '\'range\'':
        case '\'number\'': 
            return "INSERT OR REPLACE INTO Questions(id, id_form, id_owner, type, title, required, min, max) 
                    VALUES ($id, $id_form, $id_owner, $type, $title, $required, $min, $max);";
        
        case '\'date\'':
            return "INSERT OR REPLACE INTO Questions(id, id_form, id_owner, type, title, required, format) 
                    VALUES ($id, $id_form, $id_owner, $type, $title, $required, $format);";

        default:
            return "INSERT OR REPLACE INTO Questions(id, id_form, id_owner, type, title, required) 
                    VALUES ($id, $id_form, $id_owner, $type, $title, $required);";
    }
    
}