<?php

// Create connection
try {
    $connect = new PDO("sqlite:../database.db");
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\Exception $ex) {
    die("Connection failed: " . mysqli_connect_error() . "\n
                $ex->getMessage()");
}
//}


/*******************
 * REQUEST METHODS *
 *******************/

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

//TODO private case 

function getSQL_AllForms($date, $user_id, $sort, $asc_desc, $filter, $search = null)
{
    if ($search) {
        $search = "AND LOWER(Form.title) LIKE '%" . strtolower($search) . "%'";
    }

    switch ($sort) {
        case 's_title':
            $sort = "ORDER BY title " . $asc_desc;
            break;
        case 's_author':
            $sort = "ORDER BY name " . $asc_desc;
            break;
        case 's_progress':
            $sort = "ORDER BY CAST((nb_response/nb_question) AS REAL) " . $asc_desc;
            break;
        case 's_expire':
        default:
            $sort = "ORDER BY expire NOT LIKE '' " . $asc_desc . ", expire";
            break;
    }

    return
        "SELECT * 
    FROM (
        SELECT DISTINCT Form.*,User.name|| ' ' ||User.lastname AS name,SUM(Page.nb_question) as 'nb_question' 
                FROM Form 
                INNER JOIN Page ON Page.id_form = Form.id 
                INNER JOIN User ON User.id = Form.id_owner 
                WHERE (expire >= " . $date . " OR expire = '') AND Form.status != 'unreferenced' " . $search . "
                Group BY Form.id
    ) AS t1
    LEFT JOIN (
        SELECT COUNT(*) as 'nb_response' ,Form.id as id2
        FROM Result
        INNER JOIN Form ON Result.id_form = Form.id 
         WHERE Result.id_user = " . $user_id . " AND Result.answer NOT LIKE ''
         GROUP BY Form.id
    ) as t2
    ON t1.id = t2.id2 " . getFilters($filter) .$sort;
}
