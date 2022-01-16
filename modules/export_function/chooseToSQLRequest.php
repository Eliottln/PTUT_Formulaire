<?php

function chooseToSQLRequest($pdo, $id, $id_question, $id_form, $id_owner, $description)
{
    $description = $pdo->quote($description);
    return "INSERT OR REPLACE INTO Chooses VALUES ($id, $id_question, $id_form, $id_owner, $description);";
}