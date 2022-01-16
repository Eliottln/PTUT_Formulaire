<?php

function choiceToSQLRequest($pdo, $id, $id_question, $id_form, $id_owner, $description)
{
    $description = $pdo->quote($description);
    return "INSERT OR REPLACE INTO Choices VALUES ($id, $id_question, $id_form, $id_owner, $description);";
}