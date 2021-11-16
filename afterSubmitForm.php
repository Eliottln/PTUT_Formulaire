<?php

include "dom.sol";

$servername = "localhost";
$username = "Hedi";
$password = "hedizair120";
$dbname = "ptut_site_gestion_form";



// Create connection

$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

echo "<br>";


$nbChamps = count($_POST);
$sql = "INSERT INTO Form VALUES (null,". $nbChamps.");";

if (mysqli_query($conn, $sql)) {
    $last_id = mysqli_insert_id($conn);
    echo "New record created successfully.    Last isnerted ID is:  ".$last_id;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

echo " <br>";

$count = '0';
$sql = "";
print_r($_POST) ;
foreach ($_POST as $key => $value){ // On renomme la clé et la valeur en key et value, faire un print_R pour + de detail.

    $sql .= "INSERT INTO Questions VALUES(" . $count . "," . $last_id . ",'le_type'," ."'".(string)$value. "');";
    $count ++;

}


if (mysqli_multi_query($conn, $sql)) {
    echo "New records created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

?>

<div>
    <h1>Votre formulaire à bien été enregistré</h1>
</div>
