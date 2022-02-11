


function setListenerOnRightsBut(){

    let buttonRightsMenu = document.getElementsByClassName("button-rights"); // Recup tous les boutons "Gerer les droits" positionnés à coté des formulaires.
    for(let i =0; i < buttonRightsMenu.length; i++){

        buttonRightsMenu[i].addEventListener("click",displayRightsMenu);
        buttonRightsMenu[i].addEventListener("click",setForm);
        buttonRightsMenu[i].addEventListener("click",setTodo.bind(null,"rights"));
    }
}

function setListenerOnStatusBut(){
    //button-public
    let buttonPublics = document.getElementsByClassName("button-public");
    let buttonPrivates = document.getElementsByClassName("button-private");
    let buttonUnreferenced = document.getElementsByClassName("button-unreferenced")

    for(let i =0; i < buttonPublics.length; i++){
        let idPublicBut = buttonPublics[i].id;
        let idPrivateBut = buttonPrivates[i].id;
        let idUnreferencedBut = buttonUnreferenced[i].id;

        buttonPublics[i].addEventListener("click",setForm);
        buttonPublics[i].addEventListener("click",setTodo.bind(null,"status-public"));
        buttonPublics[i].addEventListener("click",sendForRights);


        buttonPrivates[i].addEventListener("click",displayRightsMenu);
        buttonPrivates[i].addEventListener("click",setTodo.bind(null,"status-private"));
        buttonPrivates[i].addEventListener("click",setForm);

        buttonUnreferenced[i].addEventListener("click",setForm);
        buttonUnreferenced[i].addEventListener("click",setTodo.bind(null,"status-unreferenced"));
        buttonUnreferenced[i].addEventListener("click",sendForRights);

    }


}

function setTodo(todo){
    let taskTodo = todo;
    todoGlobal = taskTodo;

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






idCurrentForm = 0; //
todoGlobal = "start";
groupOrUsers = "start";


menuRights = document.getElementById("pannel-rights");
listOfGroups = document.getElementById("groups-rights");
listOfUsers = document.getElementById("users-rights");
checkboxRights = document.getElementsByClassName("right-checkbox");
confirmRightsButton = document.getElementById("confirm-rights");

let showGroupsButton = document.getElementById("show-groups-rights");
let showUsersButton = document.getElementById("show-users-rights");
let exitRightsButton = document.getElementById("cancel-rights");



exitRightsButton.addEventListener("click",exitRightsMenu);

confirmRightsButton.addEventListener("click",sendForRights);
confirmRightsButton.addEventListener("click",exitRightsMenu);

showUsersButton.addEventListener("click",displayUsers);
showGroupsButton.addEventListener("click",displayGroups);




setListenerOnRightsBut();
setListenerOnStatusBut();



