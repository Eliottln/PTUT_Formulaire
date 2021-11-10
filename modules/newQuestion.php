<?php
$numQuestion=$_POST['numQuestion'];
$inputType=$_POST['id'];

function inputGenerator($input,$question){
    if ($input=='new-text'){
        return '<label for="response-text">Réponse</label>
                <input id="response-text" type="text" name="response" disabled>';
    }
    elseif ($input=='new-radio'){
        return '<p>Réponses</p>

                <label for="q'.$question.'-radio-choice1">Choix 1</label>
                <input id="q'.$question.'-radio-choice1" type="text" name="q'.$question.'-radio-choice1">
                <input id="response-radio1" type="radio" name="q'.$question.'-response" disabled>
                
                <label for="q'.$question.'-radio-choice2">Choix 2</label>
                <input id="q'.$question.'-radio-choice2" type="text" name="q'.$question.'-radio-choice2">
                <input id="response-radio2" type="radio" name="q'.$question.'-response" disabled>
                
                <button id="q'.$question.'-button" class="b-add-radio" type="button">Ajouter</button>';
    }
    elseif ($input=='new-checkbox'){
        return '<p>Réponses</p>

                <label for="q'.$question.'-checkbox-choice1">Choix 1</label>
                <input id="q'.$question.'-checkbox-choice1" type="text" name="q'.$question.'-checkbox-choice1">
                <input id="response-checkbox1" type="checkbox" name="q'.$question.'-response" disabled>
                
                <label for="q'.$question.'-checkbox-choice2">Choix 2</label>
                <input id="q'.$question.'-checkbox-choice2" type="text" name="q'.$question.'-checkbox-choice2">
                <input id="response-checkbox2" type="checkbox" name="q'.$question.'-response" disabled>
                
                <button id="q'.$question.'-button" class="b-add-checkbox" type="button">Ajouter</button>';
    }
    else
        return 'Error';
}
?>


<div>
    <label for="<?='question-num'.$numQuestion?>">Question</label>
        <textarea id="<?='question-num'.$numQuestion?>" class="question" name="<?='question-num'.$numQuestion?>" placeholder="Question" required></textarea>
</div>

<div>
    <?=inputGenerator($inputType,$numQuestion)?>
</div>
