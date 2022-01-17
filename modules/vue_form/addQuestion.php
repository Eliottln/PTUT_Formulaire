<?php

function addQuestion($_id, $_title, $_type, $option1 = null, $option2 = null)
{

    switch ($_type) {

        case 'range':
            return '<div id="question-' . $_id . '-' . $_type . '">
                        <label for="question-' . $_id . '" > ' . $_title . '</label>
                        <input id="question-' . $_id  . '" type="' . $_type . '" name="question-' . $_id . '" min="' . $option1 . '" max="' . $option2 . '" value="' . $option1 . '" required>
                        <span id="question-' . $_id  . '-counter">' . $option1 . '</span>
                    </div>';
        case 'number':
            return '<div id="question-' . $_id . '-' . $_type . '">
                        <label for="question-' . $_id . '" > ' . $_title . '</label>
                        <input id="question-' . $_id  . '" type="' . $_type . '" name="question-' . $_id . '" min="' . $option1 . '" max="' . $option2 . '" value="' . $option1 . '" required>
                    </div>';

        case 'date':
            return '<div id="question-' . $_id . '-' . $_type . '">
                        <label for="question-' . $_id . '" > ' . $_title . '</label>
                        <input id="question-' . $_id  . '" type="' . $option1 . '" name="question-' . $_id . '" required>
                    </div>';

        default:
            return '<div id="question-' . $_id . '-' . $_type . '">
                        <label for="question-' . $_id . '" > ' . $_title . '</label>
                        <input id="question-' . $_id  . '" type="' . $_type . '" name="question-' . $_id . '" required>
                    </div>';
    }
}
