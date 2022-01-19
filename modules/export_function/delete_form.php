<?php

function delete_form($pdo, $id_form)
{
    if ($id_form > 0 && !empty($pdo)) {
        $pdo->beginTransaction();
        try {

            //On crée un document, on ne connait pas encore le nb de questions donc on le met à 0 pour le modifier plus bas
            $sql = 'DELETE FROM Form WHERE id = '.$id_form;
            $sth = $pdo->prepare($sql);

            $sth->execute();

            $pdo->commit();
        } catch (\PDOException $e) {
            $pdo->rollback();
            die("Connection failed: " . $e->getLine() . "\n " . $e->getMessage());
        }
    }
}