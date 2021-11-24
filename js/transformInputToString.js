const allInput = document.querySelectorAll("input")
const formTemp = document.getElementById('export');
const button = document.getElementById("submit")
const allFormQuestion = document.querySelectorAll("form div");

button.addEventListener('click',ajoutInput)


let counter = 0;
let counterInput
let nowQuestion = "";


function ajoutInput(){

    for (counter; counter < allFormQuestion.length; counter++){
        
        for(counterInput =0; counterInput < allInput.length; counterInput++){
            let parsing = allInput[counterInput].id.split("-");
            //GERER AUSSI LE CAS DES TEXTE AREA
            console.log(parsing[0]);
            console.log(parsing[1]);
            console.log(parsing[2]);
        }
        

        /*
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
        */




    }

}


/*Recréer un formulaire puis set les valeurs des inputs avec les balises des input entière.

 */