<!DOCTYPE html>
<html lang="fr">

    <head>

        <meta charset="utf-8">
        <title>Accueil</title>
        <link type="text/css" rel="stylesheet" href="css/style.css">
        <link rel="icon" type="image/png" sizes="16x16" href="">

    </head>

    <body>

        <?php require 'modules/header.php'; ?>

        <main>
            <?php


            try {

                $connect = new PDO("sqlite:../database.db");
                $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = $connect->query("SELECT * FROM Form WHERE idDocument = ". $_GET['identity'] ."  ")->fetchAll();

                echo "Nombre de questions sur ce formulaire : " . count($sql) . "<br>";

                foreach ($sql as $key => $value){
                    echo $value['typeOfQuestion'] . "<br>";
                }




            } catch (PDOException $e) {
                echo 'Erreur sql : ' . $e->getMessage();
            }

            $connect = null;



            ?>


        </main>

        <?php require 'modules/footer.php'; ?>

    </body>


</html>
