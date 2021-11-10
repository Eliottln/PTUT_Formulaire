<?php


$servername = "iutbg-lamp.univ-lyon1.fr";
$username = "p2008444";
$password = "12008444";
$dbname = "p2008444";



// Create connection

$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";


/*foreach ($_POST as $key => $value) {
    echo "<tr> <th>$key</th> <td>$value</td> </tr>";
} ?>*/

//Récupérer le numéro du formulaire
//Insérer le formulaire dans la table Form et insérer son nombre de champs (count)
//Selectionner la clé primaire du formulaire inséré
//Insérer les questions dans la table Questions avec la clé primaire du formualaire
//

$nbChamps = count($_POST);


$sql = "INSERT INTO Form VALUES (null,". $nbChamps.")";




if (mysqli_query($conn, $sql)) {
    $last_id = mysqli_insert_id($conn);
    echo "New record created successfully.    Last isnerted ID is:  ".$last_id;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

//faire ici la boucle pour remplir la table question


$count = '0';

foreach ($_POST as $key => $value){

    /*$sql .= "INSERT INTO Questions VALUES("",".$last_id.", , );
    $count ++;*/
    //TODO
}



mysqli_close($conn);

?>

<div>
    <h1>Votre formulaire à bien été enregistré</h1>
</div>
