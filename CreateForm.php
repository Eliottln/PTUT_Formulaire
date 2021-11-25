<?php
    echo "<pre id=\"debug\"><code>";
    include_once($_SERVER["DOCUMENT_ROOT"]."/modules/ImportFile.php");
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
    <?php require 'modules/header.php'; ?>

    <main>
        <div id="palette">
            <ul>
                <li>
                    <div id="addSection" class="button">Ajouter une question</div>
                    <div id="choose-type">
                        <ul>
                            <li><div id="new-text" class="subButton">Texte</div></li>
                            <li><div id="new-radio" class="subButton">Radio</div></li>
                            <li><div id="new-checkbox" class="subButton">Checkbox</div></li>
                        </ul>
                    </div>
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
        <form id="form-document" action="https://ressources.site/" method="post">
            <button id="submit" type="submit" disabled>Enregistrer</button>

        </form>
    </main>

    <?php require 'modules/footer.php'; ?>

    <script src="/js/newQuestion.js"></script>
    <script>
        const FORM = document.getElementById("form-document");

/*        function addSection(){
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
*/
        //With parameters
        function addQuestionFromObject(name,type){
            numQuestion++;
            let div = addDivElement()

            div.innerHTML = '<div>'+
                                '<label for="question-num'+numQuestion+'">Question</label>'+
                                '<textarea id="question-num'+numQuestion+'" class="question" name="question-num'+numQuestion+'" placeholder="Question" required>'+name+'</textarea>'+
                            '</div>'

            let divQ = document.createElement("div");
            divQ.innerHTML = '<label for="response-'+type+'">Réponse</label>'+
                                '<input id="response-'+type+'" type="'+type+'" name="'+name+'" disabled>'

            div.appendChild(divQ);
        }

        function addSelectFromObject(name,array){
            numQuestion++;
            let div = addDivElement()

            div.innerHTML = '<div>'+
                                '<label for="question-num'+numQuestion+'">Question</label>'+
                                '<textarea id="question-num'+numQuestion+'" class="question" name="question-num'+numQuestion+'" placeholder="Question" required>'+name+'</textarea>'+
                            '</div>'

            let divQ = document.createElement("div");
            divQ.innerHTML = '<label for="response-select">Réponse</label>'
                                for (let index = 0; index < array.length; index++) {
                                    divQ.innerHTML += '<label for="q'+numQuestion+'-select-option-'+(index+1)+'">Option '+(index+1)+'</label>'+
                                                        '<input id="q'+numQuestion+'-select-option'+(index+1)+'" type="text" name="q'+numQuestion+'-select-option'+(index+1)+'" value="'+array[index]+'">'
                                }
            
            divQ.innerHTML += '<button id="q'+numQuestion+'-button-add-select" type="button">Ajouter</button>'
            divQ.innerHTML +='<label for="response-select">Prévisualisation</label>'
            
            let select = document.createElement('select');
            select.setAttribute('id', 'response-select');
            select.setAttribute('name',name);
                                for (let index = 0; index < array.length; index++) {
                                    select.innerHTML += '<option value="'+array[index]+'">'+array[index]+'</option>';
                                }

            div.appendChild(divQ);
            div.appendChild(select);

            const addCheckbox=document.querySelector('#q'+numQuestion+'-button-add-select')
            addCheckbox.addEventListener('click',function(){
                console.log("fonction à faire");//TODO
            })
            
        }

        function addRadioOrCheckboxFromObject(name,type,array){
            numQuestion++
            console.log(array[0]);
            let div = addDivElement()

            div.innerHTML = '<div>'+
                                '<label for="question-num'+numQuestion+'">Question</label>'+
                                '<textarea id="question-num'+numQuestion+'" class="question" name="question-num'+numQuestion+'" placeholder="Question" required>'+name+'</textarea>'+
                            '</div>'
            
            let divQ = document.createElement("div");
            divQ.innerHTML = '<p>Réponses</p>'
                    for (let index = 0; index < array.length; index++) {
                        divQ.innerHTML += '<label for="q'+numQuestion+'-'+type+'-choice'+(index+1)+'">Choix '+(index+1)+'</label>'+
                                            '<input id="q'+numQuestion+'-'+type+'-choice'+(index+1)+'" type="text" name="q'+numQuestion+'-'+type+'-choice'+(index+1)+'" value="'+array[index]+'">'+
                                            '<input type="'+type+'" name="q'+numQuestion+'-response" disabled>'
                    }

                    divQ.innerHTML +='<button id="q'+numQuestion+'-button-add-'+type+'" type="button">Ajouter</button>'

            div.appendChild(divQ)

            const addCheckbox=document.querySelector('#q'+numQuestion+'-button-add-'+type+'')
            addCheckbox.addEventListener('click',newChoice)
        }

        <?php include_once($_SERVER["DOCUMENT_ROOT"]."/modules/createInputFromObject.php");?>

        let chooseTypeisVisible = false;
        function displayChooseType(){
            if(chooseTypeisVisible){
                document.getElementById("choose-type").removeAttribute("style");
                chooseTypeisVisible++;
            }
            else{
                document.getElementById("choose-type").style.opacity = "100%";
                chooseTypeisVisible--;
            }
        }

        document.getElementById("addSection").addEventListener('click',displayChooseType);

        function resetForm(){
            let formContent = document.querySelectorAll('#form-document div');
            formContent.forEach(element => element.remove());
            numForm = 0
            numQuestion = 0
            button.setAttribute('disabled',true);
        }

        document.getElementById("ClearForm").addEventListener('click',resetForm);
        
        function showDialog(){
            try {
                document.getElementById('Import').style.display = "flex";
                document.getElementById('bgGrey').style.display = "flex";
                document.querySelector('html').style.overflowY = "hidden";
            } catch(error) {
                console.error("L'API <dialog> n'est pas prise en charge par ce navigateur.");
            }
        }

        document.getElementById("ImportForm").addEventListener('click',showDialog);

        function hideDialog(){
            try {
                document.getElementById('Import').style.display = "none";
                document.getElementById('bgGrey').style.display = "none";
                document.getElementById("Import").classList.remove("content");
                document.getElementById("confirm").setAttribute("disabled",true);
                document.querySelector('html').removeAttribute('style');
            } catch (error) {
                console.error("L'API <dialog> n'est pas prise en charge par ce navigateur.");
            }
        }

        document.getElementById("cancel").addEventListener('click',hideDialog);

        const OUTPUT =  document.getElementById('output-code');
        function ImportedFiles(event,input) {
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