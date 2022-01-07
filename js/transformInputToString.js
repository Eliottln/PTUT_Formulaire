const formTemp = document.getElementById('export')
document.getElementById('submit').addEventListener('click',addInput)


let counterInput
let tabInput = []


function addInput(){

    const allInput = document.querySelectorAll("input")
    const allTextArea = document.querySelectorAll("textarea")
    const allFormQuestion = document.querySelectorAll("#form-content>div")


    console.log("taille = "+allFormQuestion.length)

    for (let counter = 0; counter < allFormQuestion.length; counter++){

        let parsing1 = allFormQuestion[counter].id.split("-")

        let typeQuestion = parsing1[2] //Contient le type de la question (radio/checkbox ...

        //ON AJOUTE LA QUESTION AUX TABLEAU DINPUT
        let newInput = document.createElement('input')
        newInput.type = 'text'

        switch (typeQuestion) {
            case "radio":
                newInput.value = 'radioQuestion' + '/' + allTextArea[counter].value + '/' + (counter+1)
                break

            case "checkbox":
                newInput.value = 'checkBoxQuestion' + '/' + allTextArea[counter].value + '/' + (counter+1)
                break

            case "date":
                newInput.value = 'date' + '/' + allTextArea[counter].value + '/' + (counter+1)
                break

            default:
                newInput.value = 'question' + '/' + allTextArea[counter].value + '/' + (counter+1) // question/quelle est la couleur ?/1
                break;
        }

        newInput.name = allTextArea[counter].name; //On ajoute l'input au tableau d'input qu'on affiche à la fin
        tabInput.push(newInput);



        //On vérifie tout les champs input pour vérifier si ce sont des choix radio ou check box de la question actuelle.
        for(counterInput = 0; counterInput < allInput.length; counterInput++){

            let parsing2 = allInput[counterInput].id.split("-")
            let numQuestionOfInput = parsing2[0].replace('q','')

            if(numQuestionOfInput === (counter+1).toString()){ //numQuestion = numero de la question (Form), numQuestionInput= le numero de la question (Form) mais affiché a coté du choix. (voir le format)

                switch (typeQuestion) {

                    case "radio":
                        let newInput = document.createElement('input')
                        let indexChoice = parsing2[1] // Choix 1, choix 2 ...
                        console.log("Numero du choix  : " + indexChoice)
                        newInput.type = 'text'
                        newInput.name = allInput[counterInput].name
                        newInput.value = 'radioChoice' + '/' + allInput[counterInput].value + '/' + (counter+1) + '/' + indexChoice
                        tabInput.push(newInput)
                        break

                    case "checkbox":
                        let newInput2 = document.createElement('input')
                        let indexChoice2 = parsing2[1] // Choix 1, choix 2 ...
                        console.log("Numero du choix  : " + indexChoice2)
                        newInput2.type = 'text'
                        newInput2.name = allInput[counterInput].name
                        newInput2.value = 'checkBoxChoice' + '/' + allInput[counterInput].value + '/' + (counter+1) + '/' + indexChoice2
                        tabInput.push(newInput2)
                        break

                    default:
                        console.log("Le champs n'est pas un choix ")
                }
            }

        }

        //on affiche le nouveau form
        for (let i = 0; i < tabInput.length; i++){
            formTemp.appendChild(tabInput[i])
        }

    }

}


/*Recréer un formulaire puis set les valeurs des inputs avec les balises des input entière.

 */