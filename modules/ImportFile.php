<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/class/input.php");

function contains($a, $b){
    try {
        return str_contains($a, $b);
    } catch (\Throwable $th) {
        return strpos($a, $b) !== false;
    }
}

/**
 * @return returnArray
 * returnArray[0] = "type"
 * returnArray[1] = "name"
 */

function getNameAndType($array){
    $returnArray = array();
    for($i = 0; $i < count($array); $i++){
        if(contains($array[$i], "name=")){
            array_push($returnArray,$array[$i+1]);
        }
        if(contains($array[$i], "type=")){
            array_push($returnArray,$array[$i+1]);
        }
    }
    return $returnArray;
}

function getValue($array){
    for($i = 0; $i < count($array);$i++){
        if(contains($array[$i],"value")){
            return $array[$i+1];
        }
    }
    return null;
}

function getMinMax($array){
    $min = $max = null;
    for($i = 0; $i < count($array);$i++){
        if(contains($array[$i],"min")){
            $min = $array[$i+1];
        }
        if(contains($array[$i],"max")){
            $max = $array[$i+1];
        }
    }
    return array($min,$max);
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

if(!empty($_POST["fileType"])){
    switch ($_POST["fileType"]) {
        case 'xml':
        case 'html':
            try {
                $arrayStringForm = explode("<",$_POST["fileToString"]);
            
        
                //Created Object & Recover data
                $arrayObjectInput = array();
                $currentSelect = null;
                foreach($arrayStringForm as $key => $value){
                    if(contains($value, "input ")){
                        //array_push($arrayStringInput,explode("\"",$value));
                        $typeAndName = getNameAndType(explode("\"",$value));
                        
                        $valueExtracted = getValue(explode("\"",$value));
                        if(alreadyExist($arrayObjectInput,$typeAndName[1])){
                            foundObject($arrayObjectInput,$typeAndName[1])->addValue($valueExtracted);
                        }
                        else{
                            if($typeAndName[0] == "range"){
                                array_push($arrayObjectInput, new Input($typeAndName[0],$typeAndName[1]));
                                $minMax = getMinMax(explode("\"",$value));
                                foundObject($arrayObjectInput,$typeAndName[1])->addValue($minMax);
                            }
                            else{
                                array_push($arrayObjectInput, new Input($typeAndName[0],$typeAndName[1],$valueExtracted));
                            }
                            
                        }
                    
                    }
                    else if(contains($value, "select ")){
                        $typeAndName = getNameAndType(explode("\"",$value));
                        $currentSelect = new Input("select",$typeAndName[0]);
                    }
                    else if(contains($value, "option ")){
                        if(!empty($currentSelect)){
                            $valueExtracted = getValue(explode("\"",$value));
                            $currentSelect->addOption($valueExtracted);
                        }
                    }
                    else if(contains($value, "/select>")){
                        array_push($arrayObjectInput, $currentSelect);
                        $currentSelect = null;
                    }
                }
            
                //echo "Object : ";
                //var_dump($arrayObjectInput);
                //echo "Fichier HTML importé avec succés";
            } catch (Exception $e) {
                //echo $e->getLine().":".$e->getMessage()."<br>";
                //echo "L'importation du fichier HTML a échouée";
            }
            
            break;

        case 'json':
            #   code...
            //echo "Les fichier de type JSON ne sont pas encore pris en charge";
            break;
        
        default:
            #   code...
            //echo "Ce fichier est incompatible avec l'importation";
            break;
    }


}