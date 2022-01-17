<?php

function addRadio($_id, $_title, array $_RadioChoices):string{
    $resultat =  '<div id="question-'. $_id .'-radio">
                        <label>' . $_title . '</label>
                        <div>';

    foreach ($_RadioChoices as $choice) {
        $resultat .= '<div> 
                            <input class="radio" name="question-'. $_id .'" value="'. strtolower($choice['description']) .'" type="radio" id="question-'. $_id .'-'. $choice['id'].'" >
                            <label for="question-'. $_id .'-'. $choice['id'].'"> '. $choice['description'] .'</label>
                      </div>   ';
    }

    $resultat .= '    </div>
                </div>';

    return $resultat;
}