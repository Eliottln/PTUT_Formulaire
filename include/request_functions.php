<?php

function getFilters($filter)
{
    $filter = json_decode($filter);
    if(empty($filter)){
        return null;
    }
    
    $filter_request = "WHERE";
    foreach ($filter as $filt) {
        if($filt != $filter[0]){
            $filter_request .= " AND";
        }
        switch ($filt->filter) {
            case 'f_title':
                $filter_request .= " title LIKE '%" . $filt->param . "%'";
                break;
            case 'f_author':
                $filter_request .= " name LIKE '%" . $filt->param . "%'";
                break;
            case 'f_progress':
                if($filt->param == "full"){
                    $filter_request .= " (nb_response/nb_question) = 1";
                }
                elseif($filt->param == "in_progress"){
                    $filter_request .= " 1 > (nb_response/nb_question) > 0";
                }
                else{
                    $filter_request .= " nb_response IS NULL ";
                }
                break;
            case 'f_status':
                $filter_request .= " status = '" . $filt->param ."'";
                break;
        }
    }

    return $filter_request.' ';
}
