//  include this js file after newQuestion.js

try {
    const content = document.getElementById("form-document")
} catch (error) {
    //console.error("already exists")
}

function addDivElementForObject(type){ //create the div element for the question
    numQuestion++

    let div = document.createElement("div")
    content.appendChild(div)
    div.setAttribute('id', 'form-'+numQuestion+'-'+type)

    return div
}

function addQuestionFromObject(name, type) {
    let div = addDivElementForObject(type)

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
    let div = addDivElementForObject("select")

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

function addRangeFromObject(name,array){
    let div = addDivElementForObject("range")
    div.innerHTML = '<div>' +
                        '<label for="question-num' + numQuestion + '">Question</label>' +
                        '<textarea id="question-num' + numQuestion + '" class="question" name="question-num' + numQuestion + '" placeholder="Question" required>' + name + '</textarea>' +
                    '</div>'

    let divQ = document.createElement("div");
    divQ.innerHTML = '<label for="response-range">Réponse</label>' +
                        '<input id="response-range" type="range" name="' + name + '" min="' + array[0] + '" max="' + array[1] + '"disabled>'

    div.appendChild(divQ);

}

function addRadioOrCheckboxFromObject(name, type, array) {
    let div = addDivElementForObject(type)

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