<?php

function delete_form($pdo, $id_form)
{
    if ($id_form > 0 && !empty($pdo)) {
        $pdo->beginTransaction();
        try {
            
            $sql = 'DELETE FROM Rights WHERE id_form = '.$id_form.';';
            $sth = $pdo->prepare($sql);
            $sth->execute();

            $sql = 'DELETE FROM Result WHERE id_form = '.$id_form.';';
            $sth = $pdo->prepare($sql);
            $sth->execute();

            $sql = 'DELETE FROM Choice WHERE id_form = '.$id_form.';';
            $sth = $pdo->prepare($sql);
            $sth->execute();

            $sql = 'DELETE FROM Question WHERE id_form = '.$id_form.';';
            $sth = $pdo->prepare($sql);
            $sth->execute();

            $sql = 'DELETE FROM "Page" WHERE id_form = '.$id_form.';';
            $sth = $pdo->prepare($sql);
            $sth->execute();

            $sql = 'DELETE FROM Form WHERE id = '.$id_form.';';
            $sth = $pdo->prepare($sql);
            $sth->execute();
            

            $pdo->commit();
        } catch (\PDOException $e) {
            $pdo->rollback();
            die("Connection failed: " . $e->getLine() . "\n " . $e->getMessage());
        }
    }
}