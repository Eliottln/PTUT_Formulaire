



function setListenerOnRightsBut(){

    let buttonRightsMenu = document.getElementsByClassName("buttonRights");
    console.log(buttonRightsMenu)
    for(let i =0; i < buttonRightsMenu.length; i++){
        buttonRightsMenu[i].addEventListener("click",displayRightsMenu)
    }
}

function displayRightsMenu(){
    menuRights.style.display = "flex";
    document.getElementById('bgGrey').style.display = "flex"
}

function exitRightsMenu(){
    menuRights.style.display = "none";
    document.getElementById('bgGrey').style.display = "none"
}

menuRights = document.getElementById("pannel-rights");

let exitRightsButton = document.getElementById("cancel-rights");
let confirmRightsButton = document.getElementById("confirm-rights");

exitRightsButton.addEventListener("click",exitRightsMenu);


setListenerOnRightsBut();

