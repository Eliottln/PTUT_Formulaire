<?php

function choiceToSQLRequest($pdo, $id, $id_question, $id_page, $id_form, $id_owner, $description)
{
    $description = $pdo->quote($description);
    return "INSERT OR REPLACE INTO Choice VALUES ($id, $id_question, $id_page, $id_form, $id_owner, $description);";
}