<?php


function questionAlreadyExistsAndTypeDifferent($pdo, $id, $id_page, $id_form, $type)
{
    $question  = $pdo->query('SELECT * FROM Question 
                    WHERE id_form = ' . $id_form . ' 
                    AND id = ' . $id . '
                    AND id_page = ' . $id_page)->fetch();

    if ($question && $question['type'] != $type) {
        return true;
    }
    return false;
}
