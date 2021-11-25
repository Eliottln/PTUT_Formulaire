
<?php
// Ce module doit être placé dans la balise "script" et après avoir inclue "ImportFile.php"
include_once($_SERVER["DOCUMENT_ROOT"]."/class/input.php");

if(!empty($arrayObjectInput)){
    echo "let arrayValues;\n";
    for($i=0;$i<count($arrayObjectInput);$i++){
        switch($arrayObjectInput[$i]->getType()){
            
            case "select":
                $arrayToString = "[";
                foreach($arrayObjectInput[$i]->getSubInput() as $key => $value){
                    $arrayToString .= "\"".$value->getValue()."\"";
                    if($key+1 < count($arrayObjectInput[$i]->getSubInput())){
                        $arrayToString .= ",";
                    }
                }
                $arrayToString .= "];";
                echo "arrayValues = ".$arrayToString;
                echo "\naddSelectFromObject(\"".$arrayObjectInput[$i]->getName()."\",arrayValues);\n";
                break;

            case "checkbox":
            case "radio":
                $arrayToString = "[";
                foreach($arrayObjectInput[$i]->getValue() as $key => $value){
                    $arrayToString .= "\"".$value."\"";
                    if($key+1 < count($arrayObjectInput[$i]->getValue())){
                        $arrayToString .= ",";
                    }
                }
                $arrayToString .= "];";
                echo "arrayValues = ".$arrayToString;
                echo "\naddRadioOrCheckboxFromObject(\"".$arrayObjectInput[$i]->getName()."\",\"".$arrayObjectInput[$i]->getType()."\",arrayValues);\n";
                break;

            default:
                echo "addQuestionFromObject(\"".$arrayObjectInput[$i]->getName()."\",\"".$arrayObjectInput[$i]->getType()."\");\n";
        }
        
    }
    echo "button.removeAttribute('disabled')";
}
?>