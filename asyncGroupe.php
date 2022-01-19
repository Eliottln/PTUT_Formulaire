<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");


function stringCheckToTab($stringCheckValues){
    $tab = array();
    $parsing = explode("/",$stringCheckValues);
    foreach ($parsing as $value){

        array_push($tab,$value);

    }
    return $tab;

}

function usersToTab($connect, $idGroup){

    $tabUsers = Array();
    $sqlUsers = $connect->query("SELECT * FROM Groups 
                                INNER JOIN isMember AS TisMember ON TisMember.id_group = Groups.id
                                INNER JOIN Users AS Tusers ON Tusers.id = TisMember.id_user
                                WHERE Groups.id = ".$idGroup ." ")->fetchAll();

    foreach($sqlUsers as $user){
        array_push($tabUsers,$user['name']);
    }

    return $tabUsers;
}

function displayUsers($tabUser){

    $stringRet = "";

    $stringRet .= "<ul style='display: flex; flex-direction: column' >";
    foreach($tabUser as $userName){
        $stringRet .= "<li> -". $userName ." </li>";
    }
    $stringRet .= "</ul>";

    return $stringRet;
}

function displayGroups($connect,$user){

    try {
        $ret = "";
        $groups = $connect->query("SELECT * FROM Groups WHERE id_creator =".$user ." ")->fetchAll();

        foreach ($groups as $group){
            $tabUsers = usersToTab($connect, $group['id']);
            $ret .= '<div  class="bloc-groups">
                        <p>ID : '. $group['id'].' </p>
                        <p>ID Creator : '. $group['id_creator'].' </p>
                        <div>
                            <img style="width: 50px; height: 50px" src="img/groupe.png" alt="image form">
                        </div>
                            <p style="border:5px solid black; width: 100px" id="display-members">Afficher membres:</p>
                             '. displayUsers($tabUsers) . '
                            <p id="modify-group">Modifier:</p>
                        </div>
                    </div>';
        }

    }catch (PDOException $e){
        echo "Sql ERROR : " . $e;
    }

    return $ret;
}

function addGroup($connect, $stringCheckValues,$user){

    $tabUsers = stringCheckToTab($stringCheckValues);

    $connect->beginTransaction();
    try {
        $sql = "INSERT INTO Groups (id_creator)
                VALUES (" .$user. ")";
        //echo $sql;
        $statement = $connect->prepare($sql);
        $statement->execute();

        $lastIdquery = $connect->query("SELECT id FROM Groups WHERE id = (SELECT MAX(id)FROM Groups);")->fetch();
        $lastId = $lastIdquery['id'];

        $sql = "";
        foreach ($tabUsers as $idUser){
            if($idUser != ""){

                $sql = "INSERT INTO IsMember(id_user,id_group)
                VALUES (".$idUser . ",".$lastId . ");";
                $statement2 = $connect->prepare($sql);
                $statement2->execute();
            }

        }

        $connect->commit();
    } catch (PDOException $e) {
        echo $e->getLine() . " " . $e->getMessage();
        exit();
    }
}

$user = $_POST["id-user"];
$stringCheckValues = $_POST["tabcheck"];
$state = $_POST['state-page'];

if($state == 1){
    addGroup($connect,$stringCheckValues,$user);
}

$finalString = displayGroups($connect, $user);

echo $finalString;
