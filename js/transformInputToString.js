const formTemp = document.getElementById('export')
document.getElementById('submit').addEventListener('click',addInput)





function addInput(){

    let tabInput = []

    //let allInput = document.querySelectorAll("input")
    let allFormQuestion = document.querySelectorAll('#form-content div[id^="form-"]')
    let allTextArea = document.querySelectorAll('.question')


    //AJOUTE LA QUESTION AU TABLEAU DINPUT
    function addTabQuestion(type, counter){
        let newInput = document.createElement('input')
        newInput.type = 'text'

        newInput.value = type + '/' + allTextArea[counter].value + '/' + (counter+1)
        newInput.name = allTextArea[counter].name; //On ajoute l'input au tableau d'input qu'on affiche à la fin

        tabInput.push(newInput)
    }

    //AJOUTE LES CHOIX AU TABLEAU DINPUT
    function addTabChoice(type, counter){
        let choice = document.querySelectorAll('#'+allFormQuestion[counter].id+' .choice-input')

        for (let i = 0; i < choice.length; i++){
            let newInput = document.createElement('input')
            newInput.type = 'text'
            newInput.name = choice[i].name
            newInput.value = type + '/' + choice[i].value + '/' + (counter+1) + '/' + (i+1)
            tabInput.push(newInput)
        }

    }


    for (let counter = 0; counter < allFormQuestion.length; counter++){

        let typeQuestion = allFormQuestion[counter].id.split('-')[2] //Contient le type de la question (radio/checkbox ...


        switch (typeQuestion) {
            case "radio":
                addTabQuestion('radioQuestion', counter)
                addTabChoice('radioQuestion', counter)
                break

            case "checkbox":
                addTabQuestion('checkBoxQuestion', counter)
                addTabChoice('checkBoxQuestion', counter)
                break

            case "date":
                addTabQuestion('date', counter)
                break

            default:
                addTabQuestion('question', counter)    // question/quelle est la couleur ?/1
                break
        }



        //On vérifie tout les champs input pour vérifier si ce sont des choix radio ou checkbox de la question actuelle.
        /*for(let counterInput = 0; counterInput < allInput.length; counterInput++){

            let parsing = allInput[counterInput].id.split("-")
            let numQuestionOfInput = parsing[0].replace('q','')

            //numQuestion = numero de la question (Form), numQuestionInput= le numero de la question (Form) mais affiché a coté du choix. (voir le format)
            if(numQuestionOfInput === (counter+1).toString()){
                switch (typeQuestion) {

                    case "radio":
                        let newInput = document.createElement('input')
                        let indexChoice = parsing[1] // Choix 1, choix 2 ...
                        console.log("Numero du choix  : " + indexChoice)
                        newInput.type = 'text'
                        newInput.name = allInput[counterInput].name
                        newInput.value = 'radioChoice' + '/' + allInput[counterInput].value + '/' + (counter+1) + '/' + indexChoice
                        tabInput.push(newInput)
                        break

                    case "checkbox":
                        let newInput2 = document.createElement('input')
                        let indexChoice2 = parsing[1] // Choix 1, choix 2 ...
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

        }*/

        //on affiche le nouveau form
        for (let i = 0; i < tabInput.length; i++){
            formTemp.appendChild(tabInput[i])
        }

    }

}


/*Recréer un formulaire puis set les valeurs des inputs avec les balises des input entière.

 */