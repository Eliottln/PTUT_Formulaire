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

            <div>
                <h1><?php echo 'Formulaire numéro : '. $_GET['identity'] ?></h1>
            </div>

            <form action="">


            <?php


            try {

                $connect = new PDO("sqlite:../database.db");
                $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = $connect->query("SELECT * FROM Form WHERE idDocument = ". $_GET['identity'] ."  ")->fetchAll();



                foreach ($sql as $key => $value){


                    switch ($value['typeOfQuestion']){
                        case 'question':
                            echo addQuestion($value['descript'],$value['idForm']);
                            break;
                        case 'radioQuestion':

                            $sql2 = $connect->query('SELECT * FROM RadioChoice WHERE idForm='.$value['idForm'].' AND idDocument='.$value['idDocument'].';')->fetchAll();
                            $tabRadioLab = array();
                            foreach ($sql2 as $key2 => $value2){
                                array_push($tabRadioLab,$value2['descript']);
                            }

                            echo addRadioQuestion($value['descript'],$value['idForm'],$tabRadioLab);
                            break;

                        case 'checkBoxQuestion':
                            $sql3 = $connect->query('SELECT * FROM CheckBoxChoice WHERE idForm='.$value['idForm'].' AND idDocument='.$value['idDocument'].';')->fetchAll();
                            $tabRadioLab = array();
                            foreach ($sql3 as $key3 => $value3){
                                array_push($tabRadioLab,$value3['descript']);
                            }

                            echo addCheckBoxQuestion($value['descript'],$value['idForm'],$tabRadioLab);
                            break;

                        case 'date':
                            echo addDate($value['descript'],$value['idForm']);
                            break;

                        default:

                    }


                }




            } catch (PDOException $e) {
                echo 'Erreur sql : ' . $e->getMessage();
            }

            $connect = null;



            ?>
                <div >
                    <button id="S" type="button" >Envoyer</button>
                    <button id="R" type="reset">Effacer</button>
                </div>
            </form>

        </main>

        <?php require 'modules/footer.php'; ?>

    </body>


</html>

<?php

function addQuestion($_descript, $_id){
    return '<div id="question-'. $_id .'-text">
                <label for="question-'.$_id .'" > '. $_descript.'</label>
                <input id="question-'. $_id  .'" type="text" name="question-'. $_id .'" required>
            </div>
    ';
}

function addDate($_descript, $_id){
    return '<div id="question-'. $_id .'-date">
                <label for="question-'.$_id .'" > '. $_descript.'</label>
                <input id="question-'. $_id  .'" type="date" name="question-'. $_id .'" required>
            </div>
    ';
}

function addRadioQuestion($_descript, $_idQuestion, array $_tabRadioLabel):string{
    $resultat =  '<div id="question-'. $_idQuestion .'-radio">
                        <label> ' . $_descript . '</label>
                        <div>';

    for($i = 0; $i < count($_tabRadioLabel); $i++){
        $resultat .= '<div> 
                            <input class="radio" name="question-'. $_idQuestion .'" value="'. $_tabRadioLabel[$i] .'" type="radio" id="question-'. $_idQuestion .'-'. $i.'" >
                            <label for="question-'. $_idQuestion .'-'. $i.'"> '. $_tabRadioLabel[$i] .'</label>
                      </div>   ';
    }

    $resultat .= '    </div>
                </div>';

    return $resultat;
}


function addCheckBoxQuestion($_descript, $_idQuestion, array $_tabCheckBoxLabel):string{
    $resultat =  '<div id="question-'. $_idQuestion .'-checkbox">
                        <label> ' . $_descript . '</label>
                        <div>';

    for($i = 0; $i < count($_tabCheckBoxLabel); $i++){
        $resultat .= '<div> 
                            <input class="checkbox" name="question-'. $_idQuestion .'[]" value="'. $_tabCheckBoxLabel[$i] .'" type="checkbox" id="question-'. $_idQuestion .'-'. $i.'" >
                            <label for="question-'. $_idQuestion .'-'. $i.'"> '. $_tabCheckBoxLabel[$i] .'</label>
                      </div>   ';
    }

    $resultat .= '    </div>
                </div>';

    return $resultat;
}