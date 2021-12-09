const FORM = document.getElementById("document");

let chooseTypeisVisible = false
function displayChooseType() {
    if (chooseTypeisVisible) {
        document.getElementById("choose-type").removeAttribute("style")
        document.getElementById("choose-type").style.top = "-50vh"
        chooseTypeisVisible++
    }
    else {
        document.getElementById("choose-type").style.opacity = "100%"
        document.getElementById("choose-type").style.top = "32px"
        chooseTypeisVisible--
    }
}


function resetForm() {
    content.innerHTML = ''
    numQuestion = 0
    button.setAttribute('disabled', '')
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
        for (let line = 0; line < lines.length; line++) {
            OUTPUT.textContent += lines[line] + "\n"
        }
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


//ONLY FOR TEST
const DEBUG_BUTTON = document.getElementById("Debug-button")
const DEBUG = document.getElementById("debug")
let debugOpen = false

function displayDebug() {
    if (debugOpen) {
        DEBUG.style.display = "none"
        debugOpen = false
    }
    else {
        DEBUG.style.display = "flex"
        debugOpen = true
    }
}

// ADD EVENT LISTENER
try {
    document.getElementById("addSection").addEventListener('click', displayChooseType);
    document.getElementById("ClearForm").addEventListener('click', resetForm);
    document.getElementById("ImportForm").addEventListener('click', showDialog);
    document.getElementById("cancel").addEventListener('click', hideDialog);
    document.getElementById("file").addEventListener("change",ImportedFiles);
    document.getElementById("confirm").addEventListener('click', sendConfirm);
} catch (error) {
    console.error("["+error.lineNumber+"] Error : addListener failure")
}
