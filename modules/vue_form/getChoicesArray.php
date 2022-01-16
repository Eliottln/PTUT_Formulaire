<?php

function getChoicesArray($_idQuestion, array $array_choices):array{

    $question_choices = array();

    foreach ($array_choices as $choice) {
        
        if($choice['id_question'] === $_idQuestion){
            array_push($question_choices, $choice);
        }
    }

    return $question_choices;
}