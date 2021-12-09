//  include this js file after newQuestion.js

try {
    const content = document.getElementById("document")
} catch (error) {
    //console.error("already exists")
}

function addUpDownDelete(div, type){
    let move = document.createElement("div");
    move.classList.add("move");

    let up = document.createElement("button");
    up.id = '"up-' + numQuestion + '-' + type + '"';
    up.type = "button";
    up.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">'
                    +'<path fill-rule="evenodd" clip-rule="evenodd" d="M11.0001 22.2877H13.0001V7.80237L16.2428 11.045L17.657 9.63079L12.0001 3.97394L6.34326 9.63079L7.75748 11.045L11.0001 7.80236V22.2877ZM18 3H6V1H18V3Z" fill="currentColor" />'
                    +'</svg>';
    move.appendChild(up);

    let del = document.createElement("button");
    del.id = '"del-' + numQuestion + '-' + type + '"';
    del.type = "button";
    del.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">'
                    +'<path d="M16.3956 7.75734C16.7862 8.14786 16.7862 8.78103 16.3956 9.17155L13.4142 12.153L16.0896 14.8284C16.4802 15.2189 16.4802 15.8521 16.0896 16.2426C15.6991 16.6331 15.0659 16.6331 14.6754 16.2426L12 13.5672L9.32458 16.2426C8.93405 16.6331 8.30089 16.6331 7.91036 16.2426C7.51984 15.8521 7.51984 15.2189 7.91036 14.8284L10.5858 12.153L7.60436 9.17155C7.21383 8.78103 7.21383 8.14786 7.60436 7.75734C7.99488 7.36681 8.62805 7.36681 9.01857 7.75734L12 10.7388L14.9814 7.75734C15.372 7.36681 16.0051 7.36681 16.3956 7.75734Z" fill="currentColor" />'
                    +'<path fill-rule="evenodd" clip-rule="evenodd" d="M4 1C2.34315 1 1 2.34315 1 4V20C1 21.6569 2.34315 23 4 23H20C21.6569 23 23 21.6569 23 20V4C23 2.34315 21.6569 1 20 1H4ZM20 3H4C3.44772 3 3 3.44772 3 4V20C3 20.5523 3.44772 21 4 21H20C20.5523 21 21 20.5523 21 20V4C21 3.44772 20.5523 3 20 3Z" fill="currentColor" />'
                    +'</svg>';
    move.appendChild(del);

    let down = document.createElement("button");
    down.id = '"down-' + numQuestion + '-' + type + '"';
    down.type = "button";
    down.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">'
                        +'<path d="M11.0001 1H13.0001V15.4853L16.2428 12.2427L17.657 13.6569L12.0001 19.3137L6.34326 13.6569L7.75748 12.2427L11.0001 15.4853V1Z" fill="currentColor" />'
                        +'<path d="M18 20.2877H6V22.2877H18V20.2877Z" fill="currentColor" />'
                        +'</svg>';
    move.appendChild(down);
    
    div.appendChild(move);
    
    up.addEventListener('click',moveQuestion)
    down.addEventListener('click',moveQuestion)
    del.addEventListener('click',moveQuestion)
}

function addDivElementForObject(type) { //create the div element for the question
    numQuestion++

    let div = document.createElement("div")
    content.appendChild(div)
    div.setAttribute('id', 'form-' + numQuestion + '-' + type)

    return div
}

function addQuestionFromObject(name, type) {
    let div = addDivElementForObject(type)

    let form_content = document.createElement("div");
    form_content.classList.add('content');
    form_content.setAttribute('id','content-'+numQuestion);
    form_content.innerHTML = '<label id="label-' + numQuestion + '" for="q' + numQuestion + '">Question</label>' +
                            '<textarea id="q' + numQuestion + '" class="question" name="q' + numQuestion + '" placeholder="Question" required>' + name + '</textarea>'

    let divQ = document.createElement("div");
    divQ.innerHTML = '<label for="response-' + type + '">Réponse</label>' +
        '<input id="response-' + type + '" type="' + type + '" name="' + name + '" disabled>'

    form_content.appendChild(divQ);
    div.appendChild(form_content);
    addUpDownDelete(div, type)
}

function addSelectFromObject(name, array) {
    let div = addDivElementForObject("select")

    let form_content = document.createElement("div");
    form_content.classList.add('content');
    form_content.setAttribute('id','content-'+numQuestion);
    form_content.innerHTML = '<label id="label-' + numQuestion + '" for="q' + numQuestion + '">Question</label>' +
                            '<textarea id="q' + numQuestion + '" class="question" name="q' + numQuestion + '" placeholder="Question" required>' + name + '</textarea>'

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

    form_content.appendChild(divQ);
    form_content.appendChild(select);
    div.appendChild(form_content);
    addUpDownDelete(div, "select")

    const addCheckbox = document.querySelector('#q' + numQuestion + '-button-add-select')
    addCheckbox.addEventListener('click', function () {
        console.log("fonction à faire");//TODO
    })

}

function addRangeFromObject(name, array) {
    let div = addDivElementForObject("range")
    let form_content = document.createElement("div");
    form_content.classList.add('content');
    form_content.setAttribute('id','content-'+numQuestion);
    form_content.innerHTML = '<label id="label-' + numQuestion + '" for="q' + numQuestion + '">Question</label>' +
                            '<textarea id="q' + numQuestion + '" class="question" name="q' + numQuestion + '" placeholder="Question" required>' + name + '</textarea>'

    let divQ = document.createElement("div");
    divQ.innerHTML = '<label for="response-range">Réponse</label>' +
        '<input id="response-range" type="range" name="' + name + '" min="' + array[0] + '" max="' + array[1] + '"disabled>'

    form_content.appendChild(divQ);
    div.appendChild(form_content);
    addUpDownDelete(div, "range")

}

function addRadioOrCheckboxFromObject(name, type, array) {
    let div = addDivElementForObject(type)

    let form_content = document.createElement("div");
    form_content.classList.add('content');
    form_content.setAttribute('id','content-'+numQuestion);
    form_content.innerHTML = '<label id="label-' + numQuestion + '" for="q' + numQuestion + '">Question</label>' +
                            '<textarea id="q' + numQuestion + '" class="question" name="q' + numQuestion + '" placeholder="Question" required>' + name + '</textarea>'


    let divQ = document.createElement("div");
    divQ.innerHTML = '<p>Réponses</p>'
    for (let index = 0; index < array.length; index++) {
        divQ.innerHTML += '<label for="q' + numQuestion + '-' + type + '-choice' + (index + 1) + '">Choix ' + (index + 1) + '</label>' +
            '<input id="q' + numQuestion + '-' + type + '-choice' + (index + 1) + '" type="text" name="q' + numQuestion + '-' + type + '-choice' + (index + 1) + '" value="' + array[index] + '">' +
            '<input type="' + type + '" name="q' + numQuestion + '-response" disabled>'
    }

    divQ.innerHTML += '<button id="q' + numQuestion + '-button-add-' + type + '" type="button">Ajouter</button>'

    form_content.appendChild(divQ);
    div.appendChild(form_content);
    addUpDownDelete(div, type)

    const addCheckbox = document.querySelector('#q' + numQuestion + '-button-add-' + type + '')
    addCheckbox.addEventListener('click', newChoice)
}