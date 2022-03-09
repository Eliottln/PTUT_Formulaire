
<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/modules/ImportFile.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/class/input.php");

if(!empty($arrayObjectInput)){
    echo "let arrayValues;\n";
    echo "FormCreation.newPage()\n";
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
                echo "arrayValues = ".$arrayObjectInput[$i]->valueToString();
                echo "\naddRadioOrCheckboxFromObject(\"".$arrayObjectInput[$i]->getName()."\",\"".$arrayObjectInput[$i]->getType()."\",arrayValues);\n";
                break;
            
            /*case "range":
                echo "arrayValues = ".$arrayObjectInput[$i]->valueToString();
                echo "\naddRangeFromObject(\"".$arrayObjectInput[$i]->getName()."\",arrayValues);\n";
                break;*/

            default:
                echo "addQuestionFromObject(\"".$arrayObjectInput[$i]->getName()."\",\"".$arrayObjectInput[$i]->getType()."\");\n";
        }
        
    }
}
?>