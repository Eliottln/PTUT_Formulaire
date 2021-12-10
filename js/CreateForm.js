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


/*Palette */



let paletteIsOpen = true;

function togglePalette() {
    if (paletteIsOpen) {
        document.getElementById('palette').setAttribute('style', "left: 0px;");
        document.getElementById('togglePalette').setAttribute('style', "transform: rotate(180deg);");
        paletteIsOpen = false;
    } else {
        document.getElementById('palette').removeAttribute('style');
        document.getElementById('togglePalette').removeAttribute('style');
        paletteIsOpen = true;
    }
}

function showAdvancedSettings() {
    try {
        document.getElementById('settings-doc').style.display = "flex"
        document.getElementById('bgGrey').style.display = "flex"
        document.querySelector('html').style.overflowY = "hidden"
    } catch (error) {
        console.error("L'API <dialog> n'est pas prise en charge par ce navigateur.")
    }
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
    let title = document.getElementById('document-title').value;
    content.innerHTML = '<div><label>Titre<input type="text" name="title" value="' + title + '"></label></div>';
    numQuestion = 0;
    button.setAttribute('disabled', '');
}

let layout = 1;
function setLayout() {
    layout = document.getElementById("document-layout").value;
    switch (layout) {
        case '1':
            document.querySelectorAll('#document > div').forEach(e => e.style.width = 'calc(100% - 100px)');
            break;
        case '2':
            document.querySelectorAll('#document > div').forEach(e => e.style.width = 'calc(50% - 100px)');
            break;
        case '3':
            document.querySelectorAll('#document > div').forEach(e => e.style.width = 'calc(33% - 100px)');
            break;
        default:
    }
}

// ADD EVENT LISTENER
try {
    document.getElementById('togglePalette').addEventListener('click', togglePalette);

    document.getElementById("document-layout").addEventListener('change', setLayout);
    document.getElementById("ClearForm").addEventListener('click', resetForm);
    document.getElementById("ImportForm").addEventListener('click', showDialog);
    document.getElementById("AdvancedSettings").addEventListener('click', showAdvancedSettings);

    document.getElementById("cancel").addEventListener('click', hideDialog);
    document.getElementById("cancelAS").addEventListener('click', hideAS);
    document.getElementById("file").addEventListener("change", ImportedFiles);
    document.getElementById("confirm").addEventListener('click', sendConfirm);
} catch (error) {
    console.error("[" + error.lineNumber + "] Error : addListener failure");
}
