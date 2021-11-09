<?php
var_dump($_POST);
$numQuestion=$_POST['numQuestion'];
$inputType=$_POST['id'];

function inputGenerator($input){
    if ($input=='new-text'){
        return '<label for="response-text">Réponse</label>
                <input id="response-text" type="text" name="response" disabled>';
    }
    elseif ($input=='new-radio'){
        return '<label for="response-radio1">Réponse</label>
                <input id="response-radio1" type="radio" name="response" disabled>
                <label for="response-radio2">Réponse</label>
                <input id="response-radio2" type="radio" name="response" disabled>';
    }
    elseif ($input=='new-checkbox'){
        return '<label for="response-checkbox">Réponse</label>
                <input id="response-checkbox" type="checkbox" name="response" disabled>';
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
    <?=inputGenerator($inputType)?>
</div>
