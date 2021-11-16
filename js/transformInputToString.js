const allInput = document.querySelectorAll("input")
const formTemp = document.getElementById('export');
const button = document.getElementById("submit")

button.addEventListener('click',ajoutInput)


let counter2 = 0;
let nowQuestion = "";

//CA FONCTIONNE LES MEME QUESTIONS SONT ANALYSE
//FAIRE LE REGLGAGE DES RADIO BUTTON POUR BIEN LES ENVOYER DANS BDD, REMETTRE LE TYPE SUBMIT AU BOUTON DANSL E HTML POUR LE RENVOYER
function ajoutInput(){
    for (counter2; counter2 < allInput.length; counter2++){

        if(allInput[counter2].type == 'radio'){

        }
        else{
            let newInput = document.createElement('input');
            let valeur = allInput[counter2].name.split("-");
            if (nowQuestion == valeur[0]){
                console.log("Meme question, donc plusieurs choix de radio " )
            }


            nowQuestion = valeur[0];
            console.log(nowQuestion);


            newInput.type = allInput[counter2].type;
            newInput.name = allInput[counter2].name;
            newInput.value = allInput[counter2].type +"/"+ allInput[counter2].value + "/" + nowQuestion;
            formTemp.appendChild(newInput);
        }






    }

}


/*Recréer un formulaire puis set les valeurs des inputs avec les balises des input entière.

 */