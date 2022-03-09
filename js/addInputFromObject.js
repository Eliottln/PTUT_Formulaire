//  include this js file after newQuestion.js

try {
    const content = document.getElementById("document")
} catch (error) {
    //console.error("already exists")
}



function addDivElementForObject(type) { //create the div element for the question
    numQuestion++

    let div = document.createElement("div")
    content.appendChild(div)
    div.setAttribute('id', 'form-' + numQuestion + '-' + type)

    return div
}

function addSelectFromObject(name, array) {
    FormCreation.newBloc({
        id: null,
        type: "select",
        title: name
    },
    array,
    true
    )
}

function addRadioOrCheckboxFromObject(name, type, array) {
    FormCreation.newBloc({
        id: null,
        type: type,
        title: name
    },
    array,
    true
    )
}

function addQuestionFromObject(name, type) {

    FormCreation.newBloc({
        id: null,
        type: type,
        title: name
    },
    null,
    true
    )
}