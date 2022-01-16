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
                let choicesList = allFormQuestion[counter].firstChild.lastChild.children
                let nb_choices = (choicesList.length - 1)
                string += '/' + nb_choices
                for (let index = 0; index < nb_choices; index++) {
                    string += '/' + choicesList[index].children[2].value
                }
                break;

            case "number":
            case "range":
                let min = allFormQuestion[counter].firstChild.lastChild.children[0].value;  //target min
                let max = allFormQuestion[counter].firstChild.lastChild.children[2].value; //target max
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
    let expireForm = document.getElementById('document-settings-date').value
    title.setAttribute('value',
        document.getElementById('document-title-input').value +
        '/' +
        idForm +
        '/' +
        expireForm
    );
    title.setAttribute('name', "form-title-ID");

    formTemp.appendChild(title)
    tabInput.forEach(input => formTemp.appendChild(input))
}