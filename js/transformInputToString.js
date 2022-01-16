const formTemp = document.getElementById('export')
document.getElementById('submit').addEventListener('click', addInput)


/*******************************
 * 
 * forme des questions
 * 
 * choix unique : type/titre
 * 
 * choix multiple : type/titre/nombreDeChoix/titreChoix1/titreChoix2/titreChoix3/...
 * 
 *
*/

function addInput() {

    let tabInput = []

    let allFormQuestion = document.querySelectorAll('#form-content div[id^="form-"]')
    let allTextArea = document.querySelectorAll('#form-content div .question')

    //AJOUTE LES CHOIX AU QUESTION
    function addTabChoice(type, counter) {

        let string = "";

        switch (type) {
            case "radio":
            case "checkbox":
            case "select": //FIXME
                let choosesList = allFormQuestion[counter].firstChild.lastChild.children
                let nb_chooses = (choosesList.length - 2)
                string += '/' + nb_chooses
                for (let index = 1; index <= nb_chooses; index++) {
                    string += '/' + choosesList[index].children[2].value
                }
                break;

            case "number":
            case "range":
                let min = allFormQuestion[counter].firstChild.lastChild.children[1].lastChild.value;
                let max = allFormQuestion[counter].firstChild.lastChild.children[2].lastChild.value;
                string += '/' + min + '/' + max
                break;

            case "date":
                let format = document.querySelectorAll('#form-content div[id^="form-"]')[0].firstChild.lastChild.children[1].value;
                string += '/' + format
                break;
        }

        return string;
    }

    //AJOUTE LA QUESTION AU TABLEAU DINPUT
    function addTabQuestion(type, counter) {
        let newInput = document.createElement('input')
        newInput.type = 'hidden'

        newInput.value = type + '/' + allTextArea[counter].value + addTabChoice(type, counter)
        newInput.name = allTextArea[counter].name; //On ajoute l'input au tableau d'input qu'on affiche à la fin

        tabInput.push(newInput)
    }


    for (let counter = 0; counter < allFormQuestion.length; counter++) {

        let typeQuestion = allFormQuestion[counter].id.split('-')[2] //Contient le type de la question (radio/checkbox ...

        addTabQuestion(typeQuestion, counter)

    }

    //on affiche le nouveau form
    let title = document.createElement('input');
    title.setAttribute('type', 'hidden');
    let idForm = document.getElementById('document-settings-ID').innerHTML
    title.setAttribute('value',
        document.getElementById('document-title-input').value +
        '/' +
        idForm
    );
    title.setAttribute('name', "form-title-ID");

    formTemp.appendChild(title)
    tabInput.forEach(input => formTemp.appendChild(input))
}