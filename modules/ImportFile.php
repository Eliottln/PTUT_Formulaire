<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/class/input.php");

/**
 * @return returnArray
 * returnArray[0] = "type"
 * returnArray[1] = "name"
 */
function getNameAndType($array){
    $returnArray = array();
    for($i = 0; $i < count($array); $i++){
        if(str_contains($array[$i], "name=")){
            array_push($returnArray,$array[$i+1]);
        }
        if(str_contains($array[$i], "type=")){
            array_push($returnArray,$array[$i+1]);
        }
    }
    return $returnArray;
}

function getValue($array){
    for($i = 0; $i < count($array);$i++){
        if(str_contains($array[$i],"value")){
            return $array[$i+1];
        }
    }
    return null;
}

function alreadyExist($inputArray,$name){
    foreach($inputArray as $value){
        if($value->getName() == $name){
            return true;
        }
    }
    return false;
}

function foundObject($inputArray,$name){
    foreach($inputArray as $value){
        if($value->getName() == $name){
            return $value;
        }
    }
    return null;
}

if(!empty($_POST)){
    switch ($_POST["fileType"]) {
        case 'xml':
        case 'html':
            try {
                $arrayStringForm = explode("<",$_POST["fileToString"]);
            
        
                //Created Object & Recover data
                $arrayObjectInput = array();
                $arrayStringInput = array();   //Data
                $currentSelect;
                foreach($arrayStringForm as $key => $value){
                    if(str_contains($value, "input ")){
                        array_push($arrayStringInput,explode("\"",$value));
                        $typeAndName = getNameAndType(explode("\"",$value));
                        
                        $valueExtracted = getValue(explode("\"",$value));
                        if(alreadyExist($arrayObjectInput,$typeAndName[1])){
                            foundObject($arrayObjectInput,$typeAndName[1])->addValue($valueExtracted);
                        }
                        else{
                            array_push($arrayObjectInput, new Input($typeAndName[0],$typeAndName[1],$valueExtracted));
                        }
                    
                    }
                    else if(str_contains($value, "select ")){
                        array_push($arrayStringInput,explode("\"",$value));
                        $typeAndName = getNameAndType(explode("\"",$value));
                        $currentSelect = new Input("select",$typeAndName[0]);
                    }
                    else if(str_contains($value, "option ")){
                        array_push($arrayStringInput,explode("\"",$value));
                        $valueExtracted = getValue(explode("\"",$value));
                        $currentSelect->addOption($valueExtracted);
                    }
                    else if(str_contains($value, "/select>")){
                        array_push($arrayStringInput,explode("\"",$value));
                        array_push($arrayObjectInput, $currentSelect);
                        $currentSelect = null;
                    }
                }
            
                echo "Object : ";
                var_dump($arrayObjectInput);
                echo "Fichier HTML importé avec succés";
            } catch (\Throwable $th) {
                echo "L'importation du fichier HTML a échouée";
            }
            
            break;

        case 'json':
            #   code...
            echo "Les fichier de type JSON ne sont pas encore pris en charge";
            break;
        
        default:
            #   code...
            echo "Ce fichier est incompatible avec l'importation";
            break;
    }


}