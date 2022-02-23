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

//TODO private case 

function getSQL_AllForms($date,$user_id){
    return 
    "SELECT * 
    FROM (
        SELECT DISTINCT Form.*,User.name,SUM(Page.nb_question) as 'nb_question' 
                FROM Form 
                INNER JOIN Page ON Page.id_form = Form.id 
                INNER JOIN User ON User.id = Form.id_owner 
                WHERE (expire >= " . $date . " OR expire = '') AND Form.status != 'unreferenced' 
                Group BY Form.id 
                ORDER BY Form.expire NOT LIKE '' DESC, Form.expire
    ) AS t1
    LEFT JOIN (
        SELECT COUNT(*) as 'nb_response' ,Form.id as id2
        FROM Result
        INNER JOIN Form ON Result.id_form = Form.id 
         WHERE Result.id_user = " . $user_id . " AND Result.answer NOT LIKE ''
         GROUP BY Form.id
    ) as t2
    ON t1.id = t2.id2";
}

function getSQL_AllForms_Search($date,$user_id,$search){
    return 
    "SELECT * 
    FROM (
        SELECT DISTINCT Form.*,User.name,SUM(Page.nb_question) as 'nb_question' 
                FROM Form 
                INNER JOIN Page ON Page.id_form = Form.id 
                INNER JOIN User ON User.id = Form.id_owner 
                WHERE (expire >= " . $date . " OR expire = '' ) AND Form.status != 'unreferenced' AND LOWER(Form.title) LIKE '%" . strtolower($search) . "%'
                Group BY Form.id 
                ORDER BY Form.expire NOT LIKE '' DESC, Form.expire
    ) AS t1
    LEFT JOIN (
        SELECT COUNT(*) as 'nb_response' ,Form.id as id2
        FROM Result
        INNER JOIN Form ON Result.id_form = Form.id 
         WHERE Result.id_user = " . $user_id . " AND Result.answer NOT LIKE ''
         GROUP BY Form.id
    ) as t2
    ON t1.id = t2.id2";
}
