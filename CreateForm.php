<?php
    //var_dump($_FILES['importedFile']);
    
?>

<!DOCTYPE html>
<html lang="en">
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
        </div>
        <div id="bgGrey">
            <dialog id="Import">
                <form action="CreateForm.php" method="post">
                    <input onchange="ImportedFiles(event,this)" type="file" name="importedFile" id="file">

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
    <script type="text/javascript">
        const FORM = document.getElementById("Form");

        function addSection(){
            let newSection = document.createElement("section");
            let newTitle = document.createElement("label");
            let title = document.createTextNode("Title");
            let newInput = document.createElement("input");

            newTitle.appendChild(title)
            newSection.appendChild(newTitle);
            newSection.appendChild(newInput);

            FORM.appendChild(newSection);
        }

        document.getElementById("addSection").addEventListener('click',addSection);

        function newForm(){
            let formContent = document.querySelectorAll('#Form section');
            formContent.forEach(element => element.remove());
        }

        document.getElementById("ClearForm").addEventListener('click',newForm);
        
        function showDialog(){
            if (typeof document.getElementById('Import').showModal === "function") {
                document.getElementById('Import').style.display = "flex";
                document.getElementById('bgGrey').style.display = "flex";
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
                    console.log(lines[line]);
                }
            }
              
            reader.readAsText(input.files[0]);

            let fileType = input.files[0].name.split('.');

            document.getElementById("typeofFile").textContent = "Fichier de type : " + fileType[fileType.length - 1];
            document.getElementById("Import").classList.add("content")
            document.getElementById("confirm").disabled = false;
        }

        //document.getElementById("file").addEventListener('change',ImportedFiles);
    </script>
</body>
</html>

<?php
if($_FILES){
    echo 'ok';
}