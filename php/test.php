Salut les gens
<?php

function palindrome($mot){

    $motReverse = strrev($mot);
    if ($mot === $motReverse){
        return true;
    }
    else{
        return false;
    }
}


$nom  = 'ZAIR';
$prenom = "Hedi";

$demande = (string)readline('Entrez un mot : ');

if (palindrome($demande) === true) {
    echo 'Ce mot est un palindrome';
}
else{
    echo 'Pas un plaindrome';
}



?>