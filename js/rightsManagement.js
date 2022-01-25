


function setListenerOnRightsBut(){

    let buttonRightsMenu = document.getElementsByClassName("buttonRights");
    console.log(buttonRightsMenu)
    for(let i =0; i < buttonRightsMenu.length; i++){
        buttonRightsMenu[i].addEventListener("click",displayRightsMenu);
        buttonRightsMenu[i].addEventListener("click",setFormOnClick);
    }
}

function displayRightsMenu(){
    menuRights.style.display = "flex";
    document.getElementById('bgGrey').style.display = "flex";
}

function exitRightsMenu(){
    menuRights.style.display = "none";
    document.getElementById('bgGrey').style.display = "none"
}

function setFormOnClick(){
    let idForm = this.getAttribute("id").split("-")[1];
    idCurrentForm = idForm;
    console.log(idCurrentForm);

}

idCurrentForm = 0;

menuRights = document.getElementById("pannel-rights");

let exitRightsButton = document.getElementById("cancel-rights");
let confirmRightsButton = document.getElementById("confirm-rights");

exitRightsButton.addEventListener("click",exitRightsMenu);
confirmRightsButton.addEventListener("click",sendForRights);

setListenerOnRightsBut();



