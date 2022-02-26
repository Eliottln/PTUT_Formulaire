<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/request_functions.php");

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
  	                    WHERE (f.expire >= ".$date." OR f.expire = '') AND f.status = 'public' 
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
