<?php

$question = $_POST['numQuestion'];

if($_POST['class']=='b-add-radio'){
    echo '<label for="q'.$question.'-radio-choice3">Choix 3</label>
            <input id="q'.$question.'-radio-choice3" type="text" name="q'.$question.'-radio-choice3">
            <input id="response-radio3" type="radio" name="q'.$question.'-response" disabled>';
}

elseif($_POST['class']=='b-add-checkbox'){
    echo '<label for="q'.$question.'-checkbox-choice3">Choix 3</label>
            <input id="q'.$question.'-checkbox-choice3" type="text" name="q'.$question.'-checkbox-choice3">
            <input id="response-checkbox3" type="checkbox" name="q'.$question.'-response" disabled>';
}

else{
    echo "Erreur\n";
    var_dump($_POST);
}