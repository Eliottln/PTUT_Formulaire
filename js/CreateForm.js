const FORM = document.getElementById("document");

let choiceTypeisVisible = false
function displayChoiceType() {
    if (choiceTypeisVisible) {
        document.getElementById("choice-type").removeAttribute("style")
        document.getElementById("choice-type").style.top = "-50vh"
        choiceTypeisVisible++
    }
    else {
        document.getElementById("choice-type").style.opacity = "100%"
        document.getElementById("choice-type").style.top = "32px"
        choiceTypeisVisible--
    }
}

function showDialog() {
    try {
        document.getElementById('Import').style.display = "flex"
        document.getElementById('bgGrey').style.display = "flex"
        document.querySelector('html').style.overflowY = "hidden"
    } catch (error) {
        console.error("L'API <dialog> n'est pas prise en charge par ce navigateur.")
    }
}


function hideDialog() {
    try {
        document.getElementById('Import').style.display = "none"
        document.getElementById('bgGrey').style.display = "none"
        document.getElementById("Import").classList.remove("content")
        document.getElementById("confirm").setAttribute("disabled", '')
        document.querySelector('html').removeAttribute('style')
    } catch (error) {
        console.error("L'API <dialog> n'est pas prise en charge par ce navigateur.")
    }
}


const OUTPUT = document.getElementById('output-code')
function ImportedFiles() {
    OUTPUT.textContent = ""

    let reader = new FileReader()
    reader.onload = function () {
        let lines = reader.result.split('\n')
        lines.forEach(line => OUTPUT.textContent += line + "\n");
    }

    reader.readAsText(this.files[0])

    let fileType = this.files[0].name.split('.')

    document.getElementById("typeofFile").textContent = "Fichier de type : " + fileType[fileType.length - 1]
    document.getElementById("Import").classList.add("content")
    document.getElementById("confirm").disabled = false

}


function sendConfirm() {
    document.getElementById("fileToString").value = OUTPUT.textContent
    document.getElementById("fileType").value = document.getElementById("typeofFile").textContent.split(' : ')[1]
}


function exportIcon() {
    let submit = document.getElementById("submit")
    
    if (submit.disabled) {
        submit.innerHTML = '<img src="/img/lock.svg" alt="lock">';
    }
    else {
        submit.innerHTML = '<svg width="45" height="45" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">'
            + '<path d="M11 14.9861C11 15.5384 11.4477 15.9861 12 15.9861C12.5523 15.9861 13 15.5384 13 14.9861V7.82831L16.2428 11.0711L17.657 9.65685L12.0001 4L6.34326 9.65685L7.75748 11.0711L11 7.82854V14.9861Z" fill="currentColor"></path>'
            + '<path d="M4 14H6V18H18V14H20V18C20 19.1046 19.1046 20 18 20H6C4.89543 20 4 19.1046 4 18V14Z" fill="currentColor"></path>'
            + '</svg>';
    }
}

exportIcon()

/*Palette */



let paletteIsOpen = true;

function togglePalette() {
    if (paletteIsOpen) {
        document.getElementById('palette').setAttribute('style', "left: 0px;");
        paletteIsOpen = false;
    } else {
        document.getElementById('palette').removeAttribute('style');
        paletteIsOpen = true;
    }
}

let saveLayout = 1;
function showAdvancedSettings() {
    try {
        saveLayout = document.getElementById("document-layout").value
        document.getElementById('settings-doc').style.display = "flex"
        document.getElementById('bgGrey').style.display = "flex"
        document.querySelector('html').style.overflowY = "hidden"
    } catch (error) {
        console.error("L'API <dialog> n'est pas prise en charge par ce navigateur.")
    }
}

function confirmAS(){
    let newTitle = document.getElementById('document-settings-title').value;
    document.getElementById('document-title-input').value = newTitle;
    hideAS()
}

function cancelAS(){
    document.getElementById("document-layout").value = saveLayout;
    setLayout();
    hideAS();
}

function hideAS() {
    try {
        document.getElementById('settings-doc').style.display = "none"
        document.getElementById('bgGrey').style.display = "none"
        document.querySelector('html').removeAttribute('style')
    } catch (error) {
        console.error("L'API <dialog> n'est pas prise en charge par ce navigateur.")
    }
}

function resetForm() {
    content.innerHTML = '';
    numQuestion = 0;
    button.setAttribute('disabled', '');
}

let layout = 1;
function setLayout() {
    layout = document.getElementById("document-layout").value;
    switch (layout) {
        case '1':
            document.querySelectorAll('#form-content > div').forEach(e => e.style.width = 'calc(100% - 100px)');
            break;
        case '2':
            document.querySelectorAll('#form-content > div').forEach(e => e.style.width = 'calc(50% - 100px)');
            break;
        case '3':
            document.querySelectorAll('#form-content > div').forEach(e => e.style.width = 'calc(33% - 100px)');
            break;
        default:
    }
}

function rangeCounter() {
    let value = document.getElementById('document-layout').value;
    document.getElementById('document-layout-counter').innerHTML = value;
}


// ADD EVENT LISTENER
try {
    document.getElementById('togglePalette').addEventListener('click', togglePalette);
    document.querySelector('#palette>div:first-child').addEventListener('click', togglePalette);

    document.getElementById("document-layout").addEventListener('change', setLayout);
    document.getElementById("document-layout").addEventListener('change', rangeCounter);
    document.getElementById("ClearForm").addEventListener('click', resetForm);
    document.getElementById("ClearForm").addEventListener("click", exportIcon);
    document.getElementById("ImportForm").addEventListener('click', showDialog);
    document.getElementById("AdvancedSettings").addEventListener('click', showAdvancedSettings);

    document.getElementById("cancel").addEventListener('click', hideDialog);
    document.getElementById("confirmAS").addEventListener('click', confirmAS);
    document.getElementById("cancelAS").addEventListener('click', cancelAS);
    document.getElementById("file").addEventListener("change", ImportedFiles);
    document.getElementById("confirm").addEventListener('click', sendConfirm);
} catch (error) {
    console.error("[" + error.lineNumber + "] Error : addListener failure");
}

let buttonPalette = document.querySelectorAll("#addSection > button");

try {
    buttonPalette.forEach(e => e.addEventListener("click", exportIcon));
} catch (error) {
    console.error(error);
}