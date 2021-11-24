const allInput = document.querySelectorAll("input")
const allTextArea = document.querySelectorAll("textarea")
const formTemp = document.getElementById('export');
const button = document.getElementById("submit")
const allFormQuestion = document.querySelectorAll("#form-document>div");


button.addEventListener('click',ajoutInput)


let counter;
let counterInput;
let counterTextArea;
let nowQuestion = "";

let tabInput = [];


function ajoutInput(){

    for (counter =0; counter < allFormQuestion.length; counter++){

        let parsing1 = allFormQuestion[counter].id.split("-");
        numQuestion = parsing1[1];
        typeQuestion = parsing1[2];



        //ON AJOUTE LA QUESTION AUX TABLEAU DINPUT
        newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.name = allTextArea[parseInt(counter)].name;
        newInput.value = 'question' + '/' + allTextArea[parseInt(counter)].value + '/' + numQuestion;
        tabInput.push(newInput);




        //Dans le cas des input (radio button et autres choix multiples
        for(counterInput =0; counterInput < allInput.length; counterInput++){
            let parsing2 = allInput[counterInput].id.split("-");
            let numQuestionOfInput = parsing2[0].replace('q','');

            if(numQuestionOfInput === numQuestion){
                switch (typeQuestion) {
                    case "radio":
                        let newInput = document.createElement('input');
                        newInput.type = 'text'
                        newInput.name = allInput[counterInput].name;
                        newInput.value = 'radioChoice' + '/' + allInput[counterInput].value + '/' + numQuestion;
                        tabInput.push(newInput);
                        break;
                    case "checkbox":
                        let newInput2 = document.createElement('input');
                        newInput2.type = 'text'
                        newInput2.name = allInput[counterInput].name;
                        newInput2.value = 'checkBoxChoice' + '/' + allInput[counterInput].value + '/' + numQuestion;
                        tabInput.push(newInput2);
                        break;
                    default:
                        console.log("NOP");
                }
            }

            /*if(numQuestionOfInput === numQuestion && typeQuestion=== 'radio'){
                let newInput = document.createElement('input');
                newInput.type = 'text'
                newInput.name = allInput[counterInput].name;
                newInput.value = 'radioChoice' + '/' + allInput[counterInput].value + '/' + numQuestion;
                tabInput.push(newInput);

            }
            else if*/




        }

        //on affiche le nouveau form
        for (let i = 0; i < tabInput.length; i++){
            formTemp.appendChild(tabInput[i]);
        }



    }

}


/*Recréer un formulaire puis set les valeurs des inputs avec les balises des input entière.

 */