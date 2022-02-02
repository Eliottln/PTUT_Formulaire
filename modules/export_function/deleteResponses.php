<?php


function deleteResponses($pdo, $id, $id_page, $id_form)
{
    $sth = $pdo->prepare('DELETE FROM Result
                                WHERE id_form = :idForm
                                AND id_question = :idQuestion
                                AND id_page = :idPage');
    $sth->execute([
        'idForm' => $id_form,
        'idQuestion' => $id,
        'idPage' => $id_page
    ]);
}