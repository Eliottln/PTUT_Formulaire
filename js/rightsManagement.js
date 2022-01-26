


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

function displayGroups(){
    listOfUsers.style.display = "none";
    listOfGroups.style.display = "flex";
}

function displayUsers(){
    listOfGroups.style.display = "none";
    listOfUsers.style.display = "flex";
}





idCurrentForm = 0;

menuRights = document.getElementById("pannel-rights");
listOfGroups = document.getElementById("groups-rights");
listOfUsers = document.getElementById("users-rights");

let showGroupsButton = document.getElementById("show-groups-rights");
let showUsersButton = document.getElementById("show-users-rights");
let exitRightsButton = document.getElementById("cancel-rights");
let confirmRightsButton = document.getElementById("confirm-rights");

exitRightsButton.addEventListener("click",exitRightsMenu);
confirmRightsButton.addEventListener("click",sendForRights);

showUsersButton.addEventListener("click",displayUsers);
showGroupsButton.addEventListener("click",displayGroups);



setListenerOnRightsBut();



