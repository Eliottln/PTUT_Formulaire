//  include this js file after newQuestion.js

function addQuestionFromObject(name, type) {
    numQuestion++;
    let div = addDivElement()

    div.innerHTML = '<div>' +
        '<label for="question-num' + numQuestion + '">Question</label>' +
        '<textarea id="question-num' + numQuestion + '" class="question" name="question-num' + numQuestion + '" placeholder="Question" required>' + name + '</textarea>' +
        '</div>'

    let divQ = document.createElement("div");
    divQ.innerHTML = '<label for="response-' + type + '">Réponse</label>' +
        '<input id="response-' + type + '" type="' + type + '" name="' + name + '" disabled>'

    div.appendChild(divQ);
}

function addSelectFromObject(name, array) {
    numQuestion++;
    let div = addDivElement()

    div.innerHTML = '<div>' +
        '<label for="question-num' + numQuestion + '">Question</label>' +
        '<textarea id="question-num' + numQuestion + '" class="question" name="question-num' + numQuestion + '" placeholder="Question" required>' + name + '</textarea>' +
        '</div>'

    let divQ = document.createElement("div");
    divQ.innerHTML = '<label for="response-select">Réponse</label>'
    for (let index = 0; index < array.length; index++) {
        divQ.innerHTML += '<label for="q' + numQuestion + '-select-option-' + (index + 1) + '">Option ' + (index + 1) + '</label>' +
            '<input id="q' + numQuestion + '-select-option' + (index + 1) + '" type="text" name="q' + numQuestion + '-select-option' + (index + 1) + '" value="' + array[index] + '">'
    }

    divQ.innerHTML += '<button id="q' + numQuestion + '-button-add-select" type="button">Ajouter</button>'
    divQ.innerHTML += '<label for="response-select">Prévisualisation</label>'

    let select = document.createElement('select');
    select.setAttribute('id', 'response-select');
    select.setAttribute('name', name);
    for (let index = 0; index < array.length; index++) {
        select.innerHTML += '<option value="' + array[index] + '">' + array[index] + '</option>';
    }

    div.appendChild(divQ);
    div.appendChild(select);

    const addCheckbox = document.querySelector('#q' + numQuestion + '-button-add-select')
    addCheckbox.addEventListener('click', function () {
        console.log("fonction à faire");//TODO
    })

}

function addRadioOrCheckboxFromObject(name, type, array) {
    numQuestion++
    let div = addDivElement()

    div.innerHTML = '<div>' +
        '<label for="question-num' + numQuestion + '">Question</label>' +
        '<textarea id="question-num' + numQuestion + '" class="question" name="question-num' + numQuestion + '" placeholder="Question" required>' + name + '</textarea>' +
        '</div>'

    let divQ = document.createElement("div");
    divQ.innerHTML = '<p>Réponses</p>'
    for (let index = 0; index < array.length; index++) {
        divQ.innerHTML += '<label for="q' + numQuestion + '-' + type + '-choice' + (index + 1) + '">Choix ' + (index + 1) + '</label>' +
            '<input id="q' + numQuestion + '-' + type + '-choice' + (index + 1) + '" type="text" name="q' + numQuestion + '-' + type + '-choice' + (index + 1) + '" value="' + array[index] + '">' +
            '<input type="' + type + '" name="q' + numQuestion + '-response" disabled>'
    }

    divQ.innerHTML += '<button id="q' + numQuestion + '-button-add-' + type + '" type="button">Ajouter</button>'

    div.appendChild(divQ)

    const addCheckbox = document.querySelector('#q' + numQuestion + '-button-add-' + type + '')
    addCheckbox.addEventListener('click', newChoice)
}