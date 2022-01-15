<?php

function getChoosesArray($_idQuestion, array $array_chooses):array{

    $question_chooses = array();

    foreach ($array_chooses as $choose) {
        
        if($choose['id_question'] === $_idQuestion){
            array_push($question_chooses, $choose);
        }
    }

    return $question_chooses;
}