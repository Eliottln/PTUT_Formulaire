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

function creatTabGroup($connect,$idGroup){
    //REFAIRE LA REQUETE QUI FONCTIONNE PAS AVEC SQLITE 
    $tabUser = $connect->query("SELECT * FROM Groups WHERE id = ".$idGroup ." 
                                INNER JOIN isMember AS TisMember ON TisMember.id_group = id
                                INNER JOIN Users AS Tusers ON Tusers.id = TisMember.id_user
                                WHERE id = ". $idGroup ." ")->fetchAll();
}

function displayGroups($connect,$user){


    try {
        $ret = "";
        $groups = $connect->query("SELECT * FROM Groups WHERE id_creator =".$user ." ")->fetchAll();
        foreach ($groups as $group){

            $ret .= '<div class="bloc-groups">
                        <p>ID : '. $group['id'].' </p>
                        <p>ID Creator : '. $group['id_creator'].' </p>
                        <div>
                            <img style="width: 50px; height: 50px" src="img/groupe.png" alt="image form">
                        </div>
                            <a href="">Modifier</a>
                        </div>
                    </div>';
        }


    }catch (PDOException $e){
        echo "Sql ERROR : " . $e;
    }

    return $ret;
}

$user = $_POST["id-user"];
$stringCheckValues = $_POST["tabcheck"];

$finalString = displayGroups($connect, $user);
//$finalString = "        tabcheck : " . $stringCheckValues. " user : " . $user;

echo $finalString;