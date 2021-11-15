<?php
    include "class/input.php";
    echo "<pre id=\"debug\"><code>";
    if(!empty($_POST)){
        switch ($_POST["fileType"]) {
            case 'html':
                $arrayStringForm = explode("<",$_POST["fileToString"]);
                $arrayObjectInput = array();
            
                $arrayStringInput = array();
                foreach($arrayStringForm as $key => $value){
                    if(str_contains($value, "input ")){
                        array_push($arrayStringInput,explode("\"",$value));
                        array_push($arrayObjectInput, new Input());
                    }
                }
            
                for($i = 0; $i < count($arrayStringInput); $i++){
                    for($j = 0; $j < count($arrayStringInput[$i]); $j++){
                        if(str_contains($arrayStringInput[$i][$j], "name=")){
                            $arrayObjectInput[$i]->set_name($arrayStringInput[$i][$j+1]);
                        }
                        if(str_contains($arrayStringInput[$i][$j], "type=")){
                            $arrayObjectInput[$i]->set_type($arrayStringInput[$i][$j+1]);
                        }
                    }
                }
                
                echo "Object : ";
                var_dump($arrayStringInput);
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
    
    echo "</code></pre>";
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Createur de Formulaires</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header></header>
    <main>
        <div id="palette">
            <ul>
                <li>
                    <div id="addSection" class="button">Ajouter une question</div>
                </li>
                <li>
                    <div id="ClearForm" class="button">Recommencer</div>
                </li>
                <li>
                    <div id="ImportForm" class="button">importer un formulaire</div>
                </li>
            </ul>
            <div id="Debug-button" class="button">&#128421;Debug</div>
        </div>
        <div id="bgGrey">
            <dialog id="Import">
                <form action="CreateForm.php" method="post" >
                    <input onchange="ImportedFiles(event,this)" type="file" name="importedFile" id="file">

                    <input type="hidden" name="fileToString" id="fileToString">
                    <input type="hidden" name="fileType" id="fileType">

                    <button id="confirm" type="submit" disabled>Confirmer</button>
                    <button id="cancel" type="reset">Annuler</button>
                </form>
                <pre>
                    <label id="typeofFile"></label>
                    <code id="output-code"></code>
                </pre>
            </dialog>
        </div>
        <div id="Form">

        </div>
    </main>
    <script>
        const FORM = document.getElementById("Form");

        function addSection(){
            let newSection = document.createElement("section");
            let newTitle = document.createElement("input");
            newTitle.setAttribute("value", "New Title");
            newTitle.classList.add("title")
        
            let newInput = document.createElement("input");
            newInput.setAttribute("disabled", true);

            
            newSection.appendChild(newTitle);
            newSection.appendChild(newInput);

            FORM.appendChild(newSection);
        }
        
        document.getElementById("addSection").addEventListener('click',addSection);

        //With parameters
        function addSectionFromObject(name,type){
            let newSection = document.createElement("section");
            let newTitle = document.createElement("input");
            newTitle.setAttribute("value", name);
            newTitle.classList.add("title")
        
            let newInput = document.createElement("input");
            newInput.setAttribute("name", name);
            newInput.setAttribute("type", type);
            newInput.setAttribute("disabled", true);

            
            newSection.appendChild(newTitle);
            newSection.appendChild(newInput);

            FORM.appendChild(newSection);
        }

        <?php
            if(!empty($arrayObjectInput)){
                for($i=0;$i<count($arrayObjectInput);$i++){
                    echo "addSectionFromObject(\"".$arrayObjectInput[$i]->get_name()."\",\"".$arrayObjectInput[$i]->get_type()."\")\n";
                }
            }
        ?>

        

        function newForm(){
            let formContent = document.querySelectorAll('#Form section');
            formContent.forEach(element => element.remove());
        }

        document.getElementById("ClearForm").addEventListener('click',newForm);
        
        function showDialog(){
            if (typeof document.getElementById('Import').showModal === "function") {
                document.getElementById('Import').style.display = "flex";
                document.getElementById('bgGrey').style.display = "flex";
                document.querySelector('html').style.overflowY = "hidden";
            } else {
                console.error("L'API <dialog> n'est pas prise en charge par ce navigateur.");
            }
        }

        document.getElementById("ImportForm").addEventListener('click',showDialog);

        function hideDialog(){
            if (typeof document.getElementById('Import').showModal === "function") {
                document.getElementById('Import').style.display = "none";
                document.getElementById('bgGrey').style.display = "none";
                document.getElementById("Import").classList.remove("content");
                document.getElementById("confirm").setAttribute("disabled",true);
                document.querySelector('html').removeAttribute('style');
            } else {
                console.error("L'API <dialog> n'est pas prise en charge par ce navigateur.");
            }
        }

        document.getElementById("cancel").addEventListener('click',hideDialog);

        const OUTPUT =  document.getElementById('output-code');
        function ImportedFiles(event,input) {
            //newForm();
            OUTPUT.textContent = "";

            let reader = new FileReader();
            reader.onload = function(){
                let lines = reader.result.split('\n');
                for(var line = 0; line < lines.length; line++){
                    OUTPUT.textContent += lines[line] + "\n";
                }
            }
              
            reader.readAsText(input.files[0]);

            let fileType = input.files[0].name.split('.');

            document.getElementById("typeofFile").textContent = "Fichier de type : " + fileType[fileType.length - 1];
            document.getElementById("Import").classList.add("content")
            document.getElementById("confirm").disabled = false;
        }

        //document.getElementById("file").addEventListener('change',ImportedFiles);

        function sendConfirm(){
            document.getElementById("fileToString").value = OUTPUT.textContent;
            document.getElementById("fileType").value = document.getElementById("typeofFile").textContent.split(' : ')[1];
        }

        document.getElementById("confirm").addEventListener('click',sendConfirm);


        //ONLY FOR TEST
        const DEBUG_BUTTON = document.getElementById("Debug-button");
        const DEBUG = document.getElementById("debug");
        let debugOpen = false;

        function displayDebug(){
            if(debugOpen){
                DEBUG.style.display = "none";
                debugOpen = false;
            }
            else{
                DEBUG.style.display = "flex";
                debugOpen = true;
            }
        }

        DEBUG_BUTTON.addEventListener("click",displayDebug);


    </script>
</body>
</html>