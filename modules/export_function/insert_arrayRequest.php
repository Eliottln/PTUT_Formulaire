<?php

function insert_arrayRequest($pdo, $arraySQLRequest)
{
    if (is_array($arraySQLRequest)) {

        
        try {

            foreach ($arraySQLRequest as $value) {
                $sth = $pdo->prepare($value);

                $sth->execute();
            }
            
            
        } catch (\PDOException $e) {
            die("Connection failed: " . $e->getLine() . "\n " . $e->getMessage());
        }
    }
}