


function setListenerOnRightsBut(){

    let buttonRightsMenu = document.getElementsByClassName("button-rights"); // Recup tous les boutons "Gerer les droits" positionnés à coté des formulaires.
    for(let i =0; i < buttonRightsMenu.length; i++){

        buttonRightsMenu[i].addEventListener("click",displayRightsMenu);
        buttonRightsMenu[i].addEventListener("click",setForm);
        buttonRightsMenu[i].addEventListener("click",setTodo.bind(null,"rights"));
    }
}


function setTodo(todo){

    if(todo==="select"){
        todoGlobal = "status-"+statusGlobal;
        if(statusGlobal!== "private"){

        }
    }
    else{
        todoGlobal = todo;
    }

    console.log(todoGlobal);


} // Permet de modifier l'action a faire (variable global todoGlobal)

function setForm(){
    let idForm = this.getAttribute("id").split("-")[1];
    idCurrentForm = idForm;

} //Permet e modifier le fourmulaire visé lorsque l'on click (variable global idCurrentForm)

function displayRightsMenu(){
    menuRights.style.display = "flex";
    document.getElementById('bgGrey').style.display = "flex";

}

function exitRightsMenu(){
    menuRights.style.display = "none";
    document.getElementById('bgGrey').style.display = "none"
    listOfUsers.style.display = "none";
    listOfGroups.style.display = "none";
    confirmRightsButton.style.display = "none";

    reinitCheckBox();

}

function displayGroups(){
    listOfUsers.style.display = "none";
    listOfGroups.style.display = "flex";
    confirmRightsButton.style.display = "flex";
    groupOrUsers = "group";

}

function displayUsers(){
    listOfGroups.style.display = "none";
    listOfUsers.style.display = "flex";
    confirmRightsButton.style.display = "flex";
    groupOrUsers = "users";


}

function getCheckedBox(){
    let ret = "";
    let cpt = 0;
    for(let i =0; i<checkboxRights.length;i++){
        if(checkboxRights[i].checked === true){
            if(cpt === 0){
                ret += checkboxRights[i].id;
            }else{
                ret += "/"+ checkboxRights[i].id;
            }
            cpt++

        }

    }

    return ret;
}

function reinitCheckBox(){
    for(let i =0; i<checkboxRights.length;i++){
        checkboxRights[i].checked = false;

    }
}

function setListenerOnStatusSlct(){


    for(let i =0; i < selectStatus.length; i++){

        selectStatus[i].addEventListener("change",setForm);
        selectStatus[i].addEventListener("change",setStatus);
        selectStatus[i].addEventListener("change",setTodo.bind(null,"select"));
        selectStatus[i].addEventListener("change",validationStatus); //Regarde si on doit directement envoyer les données ou afficher la gestion des droits (si on veut mettre en privé)

    }


}

function validationStatus(){
    if(this.value !== "private"){
        sendForRights();
    }
    else{
        displayRightsMenu();
    }
}

function setStatus(){
    statusGlobal = this.value;

}


idCurrentForm = 0; //
todoGlobal = "start";
groupOrUsers = "start";
statusGlobal = "none";


menuRights = document.getElementById("pannel-rights");
listOfGroups = document.getElementById("groups-rights");
listOfUsers = document.getElementById("users-rights");
checkboxRights = document.getElementsByClassName("right-checkbox");
confirmRightsButton = document.getElementById("confirm-rights");

selectStatus = document.getElementsByClassName("status-select");

let showGroupsButton = document.getElementById("show-groups-rights");
let showUsersButton = document.getElementById("show-users-rights");
let exitRightsButton = document.getElementById("cancel-rights");


exitRightsButton.addEventListener("click",exitRightsMenu);

confirmRightsButton.addEventListener("click",sendForRights);
confirmRightsButton.addEventListener("click",exitRightsMenu);

showUsersButton.addEventListener("click",displayUsers);
showGroupsButton.addEventListener("click",displayGroups);



sendForRights();




