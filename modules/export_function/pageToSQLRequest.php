<?php

function pageToSQLRequest($pdo, $id, $id_form, $id_owner, $nb_question, $title, array $tab_color = null)
{
    // tab_color size = 4
    $title = $pdo->quote($title);
    if (empty($tab_color)) {
        $colorToSend = ['#E7E7E7', '#FFF', '#000', '#FFF'];
    } else {
        $colorToSend = array();
        foreach ($tab_color as $color) {
            array_push($colorToSend, $color);
        }
    }

    return "INSERT OR REPLACE INTO 'Page' VALUES ($id, $id_form, $id_owner, $nb_question, $title
                                                    ,".$pdo->quote($colorToSend[0])."
                                                    ,".$pdo->quote($colorToSend[1])."
                                                    ,".$pdo->quote($colorToSend[2])."
                                                    ,".$pdo->quote($colorToSend[3]).");";
}
