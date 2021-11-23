const allInput = document.querySelectorAll("input")
const formTemp = document.getElementById('export');
const button = document.getElementById("submit")

button.addEventListener('click',ajoutInput)


let counter = 0;
let nowQuestion = "";

//CA FONCTIONNE LES MEME QUESTIONS SONT ANALYSE
//FAIRE LE REGLGAGE DES RADIO BUTTON POUR BIEN LES ENVOYER DANS BDD, REMETTRE LE TYPE SUBMIT AU BOUTON DANSL E HTML POUR LE RENVOYER
function ajoutInput(){
    for (counter; counter < allInput.length; counter++){

        let valeur = allInput[counter].name.split("-"); //Split le nom de l'input, qui est sous la forme qX-type-n°;

        if(allInput[counter].type != 'radio'){

            let newInput = document.createElement('input');
            nowQuestion = valeur[0];
            $type = valeur[1]; //Suelement dans le cas ou c'est un radioButton, sinn la variable est à undefined

            if($type == 'radio' ){

                //faire un newInput avec toute les valeurs des radio
                newInput.type = 'text';
                newInput.name = newInput.name = allInput[counter].name;
                newInput.value = 'radioChoice' +"/"+ allInput[counter].value + "/" + nowQuestion;

            }
            else{

                newInput.type = allInput[counter].type;
                newInput.name = allInput[counter].name;
                newInput.value = allInput[counter].type +"/"+ allInput[counter].value + "/" + nowQuestion;

            }

            formTemp.appendChild(newInput); // On crée dans le formulaire export un nouveau champ div

        }





    }

}


/*Recréer un formulaire puis set les valeurs des inputs avec les balises des input entière.

 */