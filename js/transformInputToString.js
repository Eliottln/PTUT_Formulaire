const allInput = document.querySelectorAll("input")
const formTemp = document.getElementById('export');
const button = document.getElementById("submit")

button.addEventListener('click',ajoutInput)

let counter = 0;
let counter2 = 0;

/*function send(){
    for (counter; counter < allInput.length; counter++){
        console.log(allInput[counter]);
    }
}*/

function ajoutInput(){
    for (counter2; counter2 < allInput.length; counter2++){
        let newInput = document.createElement('input');
        newInput.type = allInput[counter2].type;
        newInput.name = allInput[counter2].name;
        newInput.value = allInput[counter2].type +"/"+ allInput[counter2].value;
        formTemp.appendChild(newInput);

    }

}


/*Recréer un formulaire puis set les valeurs des inputs avec les balises des input entière.

 */