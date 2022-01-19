<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");

function deleteGroups($connect, $group){

    try {

        $stmt = $connect->prepare("DELETE FROM IsMember WHERE id_group = ".$group ." ");
        $stmt->execute();

        $stmt2 = $connect->prepare("DELETE FROM 'Group' WHERE id = ".$group ." ");
        $stmt2->execute();

    }catch(PDOException $e){
        echo "SQL ERROR : " . $e->getMessage();
    }

}

function displaySelectGroups($connect,$user){
    $retString ='<option value="none">--Selectionner un groupe--</option>';
    try {
        $groups = $connect->query("SELECT * FROM 'Group' where id_creator = ". $user." ")->fetchAll();
        foreach ($groups as $group){
            $retString .= '<option value="'.$group['id'] . '">'.$group['id'].'</option>';
        }

        foreach($groups as $group){

        }
    }catch (PDOException $e){
        echo "SQL ERROR : " . $e->getMessage();
    }

    return $retString;
}

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
    $sqlUsers = $connect->query("SELECT * FROM 'Group' 
                                INNER JOIN isMember AS TisMember ON TisMember.id_group = 'Group'.id
                                INNER JOIN User AS Tusers ON Tusers.id = TisMember.id_user
                                WHERE 'Group'.id = ".$idGroup ." ")->fetchAll();

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
        
        $groups = $connect->query("SELECT * FROM 'Group' WHERE id_creator = ".$user ." ")->fetchAll();

        foreach ($groups as $group){
            $tabUsers = usersToTab($connect, $group['id']);
            $ret .= '<div  class="bloc-groups">
                        <p>ID : '. $group['id'].' </p>
                        <p>ID Creator : '. $group['id_creator'].' </p>
                        <div>
                            <img style="width: 50px; height: 50px" src="img/groupe.png" alt="image form">
                        </div>
                            <img id="display-members-'.$group['id'] .'" style = "height: 20px; width: 20px" src="img/plusvert.png" alt="afficher les membres">
                            <img id="hide-members-'.$group['id'] .'" style = "height: 20px; width: 20px" src="img/moinsrouge.png" alt="masquer les membres">
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
        $sql = "INSERT INTO 'Group' (id_creator)
                VALUES (" .$user. ")";

        $statement = $connect->prepare($sql);
        $statement->execute();

        $lastIdquery = $connect->query("SELECT id FROM 'Group' WHERE id = (SELECT MAX(id)FROM 'Group's);")->fetch();
        $lastId = $lastIdquery['id'];


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
$todo = $_POST['todo'];

if($todo == "add"){
    addGroup($connect,$stringCheckValues,$user);
}
else if($todo == "del"){
    $groupToDel = $_POST['deleted-group'];
    deleteGroups($connect, $groupToDel);
}


$finalStringBloc = displayGroups($connect, $user);
$finalStringSelect = displaySelectGroups($connect, $user);

echo $finalStringBloc . "///" . $finalStringSelect ;
