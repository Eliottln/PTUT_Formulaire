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

function getSQL_AllForms($date, $user_id, $sort, $asc_desc, $filter, $search = null)
{
    if ($search) {
        $search = "WHERE LOWER(Forms.title) LIKE '%" . strtolower($search) . "%'";
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
        SELECT DISTINCT Forms.*,User.name|| ' ' ||User.lastname AS name,SUM(Page.nb_question) as 'nb_question' 
                FROM (
                        SELECT f.*
  	                    FROM Form f
  	                    LEFT JOIN Rights r ON f.id = r.id_form
  	                    WHERE r.id_owner = " . $user_id . " OR r.id_guest = " . $user_id . "
  	                    Group BY f.id
                    UNION
  	                    SELECT f.*
  	                    FROM Form f
  	                    WHERE (f.expire >= '2022-02-26' OR f.expire = '') AND f.status = 'public' 
                ) AS Forms 
                INNER JOIN Page ON Page.id_form = Forms.id 
                INNER JOIN User ON User.id = Forms.id_owner 
                " . $search . "
                Group BY Forms.id
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
