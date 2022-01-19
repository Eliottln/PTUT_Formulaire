<?php

function insert_form($pdo, $id, $id_owner, $nb_page = null, $title = null, $expire = null)
{
    if (!empty($id_owner)) {
        $pdo->beginTransaction();
        try {

            //On crée un document, on ne connait pas encore le nb de questions donc on le met à 0 pour le modifier plus bas
            $sql = 'INSERT OR REPLACE INTO Form VALUES ('. $pdo->quote($id) .
                                                        ', ' . $pdo->quote($id_owner) . 
                                                        ', ' . $pdo->quote($nb_page) . 
                                                        ', ' . $pdo->quote($title) .
                                                        ', ' . $pdo->quote($expire) . ');';
            $sth = $pdo->prepare($sql);

            $sth->execute();

            $pdo->commit();
        } catch (\PDOException $e) {
            $pdo->rollback();
            die("Connection failed: " . $e->getLine() . "\n " . $e->getMessage());
        }
    }
}
