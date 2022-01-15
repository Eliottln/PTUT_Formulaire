<?php

function addRadio($_id, $_title, array $_RadioChooses):string{
    $resultat =  '<div id="question-'. $_id .'-radio">
                        <label>' . $_title . '</label>
                        <div>';

    foreach ($_RadioChooses as $choose) {
        $resultat .= '<div> 
                            <input class="radio" name="question-'. $_id .'" value="'. strtolower($choose['description']) .'" type="radio" id="question-'. $_id .'-'. $choose['id'].'" >
                            <label for="question-'. $_id .'-'. $choose['id'].'"> '. $choose['description'] .'</label>
                      </div>   ';
    }

    $resultat .= '    </div>
                </div>';

    return $resultat;
}