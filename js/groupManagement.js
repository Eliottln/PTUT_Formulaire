

function displayMembersOfGroup(group){
    let liste = document.getElementById("liste-"+group);
    liste.style.display = "flex";
}

function hideMembersOfGroup(group){
    let liste = document.getElementById("liste-"+group);
    liste.style.display = "none";
}

function displayEditMenu(){
    menuEdit.style.display = 'flex';
    document.getElementById('bgGrey').style.display = "flex"

}

function exitEditMenu(){
    menuEdit.style.display = 'none';
    document.getElementById('bgGrey').style.display = "none"

    for(let i =0 ; i < checkboxs.length; i++){
        checkboxs[i].checked = false;
    }
}


function displayGroupMenu(){
    menuGroup.style.display = 'flex';
    document.getElementById('bgGrey').style.display = "flex"

}

function exitGroupMenu(){
    menuGroup.style.display = 'none';
    document.getElementById('bgGrey').style.display = "none"

    for(let i =0 ; i < checkboxs.length; i++){

        checkboxs[i].checked = false;
    }
}

function selectAll(){

    for(let i =0; i < checkboxs.length/2; i++){

        checkboxs[i].checked = true;
    }

}

function unselectAll(){
    for(let item in checkboxs){

        checkboxs[item].checked = false;
    }
}

function selection(){
    this.state = !this.state;

    if(this.state){
        selectAll()
    }else{
        unselectAll()
    }



}

function tabCheckToString(tabCheck){
    let ret = "";

    for(let i=0; i < tabCheck.length; i++){

        if(tabCheck[i].checked === true) {
            if (i === tabCheck.length - 1)
                ret += tabCheck[i].id;

            else {
                ret += tabCheck[i].id + "/";
            }
        }

    }

    console.log(ret);
    return ret;
}


function setEventListnerOnMembers(){

    let imgOfGroups = document.getElementsByClassName("img-of-group");

    for(let i = 0; i< imgOfGroups.length; i++){

        imgOfGroups[i].addEventListener('click',showMembers)

    }
}

function showMembers(){

    let id = "list-of-" + this.getAttribute("id").split("-")[2];

    let list = document.getElementById(id);

    if(list.style.display === "flex"){
        list.style.display = "none";
        list.parentElement.style.display = "none";
    }
    else{
        list.style.display = "flex";
        list.parentElement.style.display = "flex";
    }
        

}


checkboxs = document.getElementsByClassName("user-checkb"); //toutes les checkbox

let checkboxAll = document.getElementById("select-all-users");
let confirmButton = document.getElementById("confirm"); //Ajouter


menuGroup = document.getElementById("pannel-group");
let menuGroupButton = document.getElementById("pannel-group-button");
let exitMenuGroupButton = document.getElementById("cancel");


menuEdit = document.getElementById("pannel-edit");
let editGroupButton = document.getElementById("edit-group-button");
let exitEditGroupButton = document.getElementById("cancel-delete")
let confirmEditButton = document.getElementById("confirm-edit") // Modifier
let confirmDeleteButton = document.getElementById("confirm-delete"); //Supprimer




checkboxAll.addEventListener('change',selection); //La checkbox pour tout sélectionner

menuGroupButton.addEventListener('click',displayGroupMenu);
exitMenuGroupButton.addEventListener('click',exitGroupMenu)
confirmButton.addEventListener('click', sendForGroups.bind(null,"add"));
confirmButton.addEventListener('click',exitGroupMenu)

editGroupButton.addEventListener('click',displayEditMenu);
exitEditGroupButton.addEventListener('click',exitEditMenu);
confirmDeleteButton.addEventListener('click',sendForGroups.bind(null,"del"));
confirmDeleteButton.addEventListener('click',exitEditMenu)
confirmEditButton.addEventListener('click',sendForGroups.bind(null,"modify"));
confirmEditButton.addEventListener('click',exitEditMenu);


state=0;
isArrivedOnPage = 0;

sendForGroups("start");