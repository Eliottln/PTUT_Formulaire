
let buttonOptions = document.querySelectorAll("#addSection > button");

try {
    buttonOptions.forEach(e => e.addEventListener('click', newQuestion));
} catch (error) {
    console.error(error);
}

const content = document.getElementById('form-content')
const button = document.getElementById('submit')

let numQuestion = 0
const choice = new Map();


/****************************************************/


function newQuestion(){ //create a question input with response input in html

    button.removeAttribute('disabled')

    const id = this.value

    let question = addDivElement(id).id;

    let div = document.querySelector('#'+question+' .content')


    switch (id){
/*        case 'new-text':
            div.appendChild(createSimpleInput('text'))
            break

        case 'new-email':
            div.appendChild(createSimpleInput('email'))
            break

        case 'new-tel':
            div.appendChild(createSimpleInput('tel'))
            break

        case 'new-color':
            div.appendChild(createSimpleInput('color'))
            break

        case 'new-file':
            div.appendChild(createSimpleInput('file'))
            break

        case 'new-url':
            div.appendChild(createSimpleInput('url'))
            break*/

        case 'new-number':
            div.appendChild(createRangeInput('number'))
            break

        case 'new-range':
            div.appendChild(createRangeInput('range'))
            break

        case 'new-radio':
            createRadioOrCheckbox('radio', div)
            break

        case 'new-checkbox':
            createRadioOrCheckbox('checkbox', div)
            break

        case 'new-select':
            createSelect(div)
            break

        case 'new-date':
            let divD = document.createElement("div");

            divD.innerHTML = '<p>Réponses</p>'+
                '<select id="select-date-'+numQuestion+'" name="select-date-'+numQuestion+'">'+
                '<option value="date">Date</option>'+
                '<option value="time">Heure</option>'+
                '<option value="datetime-local">Date-heure</option>'+
                '<option value="duration">Durée</option>'+
                '</select>'+

                '<div id="date-'+numQuestion+'">'+
                '<input type="date" disabled>'+
                '</div>'

            div.appendChild(divD)
            document.getElementById('select-date-'+numQuestion).addEventListener('change',createDate)
            break

        default:
            div.appendChild(createSimpleInput(id.split('-')[1]))
            break
    }

}


function addDivElement(id){ //create the div element for the question
    numQuestion++

    let type = id.split("-")[1]
    let div = document.createElement("div")
    div.id = 'form-'+numQuestion+'-'+type

    div.innerHTML = '<div class="content">'+
        '<label>Question ('+type+')'+
        '<textarea class="question" name="q'+numQuestion+'" placeholder="Question" required></textarea>'+
        '</label>'+
        '</div>'+

        '<div class="move">'+
        '<button id="up-'+numQuestion+'-'+type+'" type="button">'+
        '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">'
        +'<path fill-rule="evenodd" clip-rule="evenodd" d="M11.0001 22.2877H13.0001V7.80237L16.2428 11.045L17.657 9.63079L12.0001 3.97394L6.34326 9.63079L7.75748 11.045L11.0001 7.80236V22.2877ZM18 3H6V1H18V3Z" fill="currentColor" />'
        +'</svg>'
        +'</button>'+
        '<button id="del-'+numQuestion+'-'+type+'" type="button">'+
        '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">'
        +'<path d="M16.3956 7.75734C16.7862 8.14786 16.7862 8.78103 16.3956 9.17155L13.4142 12.153L16.0896 14.8284C16.4802 15.2189 16.4802 15.8521 16.0896 16.2426C15.6991 16.6331 15.0659 16.6331 14.6754 16.2426L12 13.5672L9.32458 16.2426C8.93405 16.6331 8.30089 16.6331 7.91036 16.2426C7.51984 15.8521 7.51984 15.2189 7.91036 14.8284L10.5858 12.153L7.60436 9.17155C7.21383 8.78103 7.21383 8.14786 7.60436 7.75734C7.99488 7.36681 8.62805 7.36681 9.01857 7.75734L12 10.7388L14.9814 7.75734C15.372 7.36681 16.0051 7.36681 16.3956 7.75734Z" fill="currentColor" />'
        +'<path fill-rule="evenodd" clip-rule="evenodd" d="M4 1C2.34315 1 1 2.34315 1 4V20C1 21.6569 2.34315 23 4 23H20C21.6569 23 23 21.6569 23 20V4C23 2.34315 21.6569 1 20 1H4ZM20 3H4C3.44772 3 3 3.44772 3 4V20C3 20.5523 3.44772 21 4 21H20C20.5523 21 21 20.5523 21 20V4C21 3.44772 20.5523 3 20 3Z" fill="currentColor" />'
        +'</svg>'
        +'</button>'+
        '<button id="down-'+numQuestion+'-'+type+'" type="button">'+
        '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">'
        +'<path d="M11.0001 1H13.0001V15.4853L16.2428 12.2427L17.657 13.6569L12.0001 19.3137L6.34326 13.6569L7.75748 12.2427L11.0001 15.4853V1Z" fill="currentColor" />'
        +'<path d="M18 20.2877H6V22.2877H18V20.2877Z" fill="currentColor" />'
        +'</svg>'
        +'</button>'+
        '</div>'

    content.appendChild(div)
    document.getElementById('up-'+numQuestion+'-'+type).addEventListener('click',moveQuestion)
    document.getElementById('del-'+numQuestion+'-'+type).addEventListener('click',moveQuestion)
    document.getElementById('down-'+numQuestion+'-'+type).addEventListener('click',moveQuestion)

    return div
}


/****************************************************/


function moveQuestion(){
    const id = this.id
    const question = Number.parseInt(id.split('-')[1])
    const type = id.split('-')[2]
    let current = document.getElementById('form-'+question+'-'+type)


    if (id.startsWith('del')){
        current.remove()
        numQuestion--

        if (numQuestion===0){
            button.setAttribute('disabled','')
        }else {

            let q = document.querySelectorAll('div[id^="form-"]')

            q.forEach(e => {

                let numBlock = Number.parseInt(e.id.split("-")[1])
                if (numBlock > question) {
                    update(e, -1)
                }
            })
        }
        if(typeof(choice.get(numQuestion+1)) !== 'undefined'){
            choice.delete(numQuestion+1)
        }

    }

    else if (id.startsWith('up') && (question-1) > 0){
        let node = document.querySelector('div[id^="form-'+(question-1)+'"]')
        swapNodes(node, current)
    }

    else if (id.startsWith('down') && question !== numQuestion){
        let node = document.querySelector('div[id^="form-'+(question+1)+'"]')
        swapNodes(current, node)
    }
}


function update(node,i){

    let numBlock = Number.parseInt(node.id.split("-")[1])
    let typeBlock = node.id.split("-")[2]
    node.id = 'form-'+(numBlock + i)+'-'+typeBlock

    document.querySelector('#'+node.id+' > div > label > textarea').setAttribute('name', 'q'+(numBlock+i))

    document.getElementById('up-'+numBlock+'-'+typeBlock).id = 'up-'+(numBlock + i)+'-'+typeBlock
    document.getElementById('del-'+numBlock+'-'+typeBlock).id = 'del-'+(numBlock + i)+'-'+typeBlock
    document.getElementById('down-'+numBlock+'-'+typeBlock).id = 'down-'+(numBlock + i)+'-'+typeBlock

    switch (typeBlock){

        case 'range':
            let min = document.getElementById('min-'+numBlock)
            min.id = 'min-'+(numBlock + i)
            min.setAttribute('name',min.id)
            let max = document.getElementById('max-'+numBlock)
            max.id = 'max-'+(numBlock + i)
            max.setAttribute('name',max.id)
            break

        case 'radio':
            updateNumRC(numBlock,typeBlock,i)
            break

        case 'checkbox':
            updateNumRC(numBlock,typeBlock,i)
            break

        case 'select':
            updateNumRC(numBlock,typeBlock,i)
            break

        case 'date':
            let select = document.getElementById('select-date-'+numBlock)
            select.id = 'select-date-'+(numBlock + i)
            select.setAttribute('name',select.id)
            document.getElementById('date-'+numBlock).id = 'date-'+(numBlock + i)
            break

        default:
            break
    }

}


function updateNumRC(numBlock,typeBlock,j){

    for (let i = 1; i <= choice.get(numBlock); i++) {

        document.getElementById('choice-' + numBlock + '-' + i).id = 'choice-' + (numBlock + j) + '-' + i

        let label = document.getElementById('label-' + numBlock + '-' + i)
        label.setAttribute('for', 'q' + (numBlock + j) + '-' + i)
        label.id = 'label-' + (numBlock + j) + '-' + i

        let input = document.getElementById('q' + numBlock + '-' + i)
        input.setAttribute('name', 'q' + (numBlock + j) + '-' + typeBlock + i)
        input.id = 'q' + (numBlock + j) + '-' + i

        let button = document.getElementById('trash-' + numBlock + '-' + i + '-' + typeBlock)
        button.id = 'trash-' + (numBlock + j) + '-' + i + '-' + typeBlock
        button.addEventListener('click', delChoice)

    }

    choice.set((numBlock+j),choice.get(numBlock))

    let button2 = document.getElementById('q'+numBlock+'-add-'+typeBlock)
    button2.setAttribute('name',(numBlock + j).toString())
    button2.id = 'q'+(numBlock + j)+'-add-'+typeBlock
    button2.addEventListener('click',newChoice)
}


function swapNodes(node1, node2) {

    let node2_copy = node2.cloneNode(true);
    node1.parentNode.insertBefore(node2_copy, node1);
    node2.parentNode.insertBefore(node1, node2);
    node2.parentNode.replaceChild(node2, node2_copy);

    let num = Number.parseInt(node1.id.split("-")[1])

    update(node1,-num)
    update(node2,-1)
    update(node1,num+1)
}


function createSimpleInput(type){
    let div = document.createElement("div");
    div.innerHTML = '<label>Réponse'+
        '<input type="'+type+'" disabled>'+
        '</label>'
    return div
}


function createRangeInput(type){
    let div = document.createElement("div");
    div.innerHTML = '<label>Réponse'+
        '<input type="'+type+'" disabled>'+
        '</label>'+
        '<label>Min :'+
        '<input id="min-'+numQuestion+'" type="number" name="min-'+numQuestion+'" value="0">'+
        '</label>'+
        '<label>Max :'+
        '<input id="max-'+numQuestion+'" type="number" name="max-'+numQuestion+'" value="10">'+
        '</label>'
    return div
}


function createRadioOrCheckbox(type, div){

    choice.set(numQuestion,2)

    let divQ = document.createElement("div");
    divQ.innerHTML = '<p>Réponses</p>'+
        '<div class="choice">'+
            '<input type="'+type+'" disabled>'+
            '<label for="choice-'+numQuestion+'1">Choix 1</label>'+
            '<input id="choice-'+numQuestion+'1" class="choice-input" type="text" name="choice-'+numQuestion+'1">'+
            '<button id="trash-1" type="button">Supprimer</button>'+
        '</div>'+


        '<div class="choice">'+
            '<input type="'+type+'" disabled>'+
            '<label for="choice-'+numQuestion+'2">Choix 2</label>'+
            '<input id="choice-'+numQuestion+'2" class="choice-input" type="text" name="choice-'+numQuestion+'2">'+
            '<button id="trash-2" type="button">Supprimer</button>'+
        '</div>'+


        '<button class="add-'+type+'" type="button">Ajouter</button>'

    div.appendChild(divQ)

    document.getElementById('trash-1').addEventListener('click',delChoice)
    document.getElementById('trash-2').addEventListener('click',delChoice)
    document.querySelector('#'+div.parentElement.id+' .add-'+type).addEventListener('click',newChoice)
}


function newChoice(){ //add a choice for multi input

    let type = this.className.split("-")[1]
    let question = this.closest('.content').parentElement.id.split('-')[1]
    let num = this.parentElement.childElementCount - 1

    let add='<div class="choice">'+
                '<input type="'+type+'" disabled>'+
                '<label for="choice-'+question+num+'">Choix '+num+'</label>'+
                '<input id="choice-'+question+num+'" class="choice-input" type="text" name="choice-'+question+num+'">'+
                '<button id="trash-'+num+'" type="button">Supprimer</button>'+
            '</div>'

    this.insertAdjacentHTML("beforebegin", add);

    document.getElementById('trash-'+num).addEventListener('click',delChoice)
}


function delChoice(){ //delete a choice for multi input

    let rootID = this.closest('.content').parentElement.id
    let question = rootID.split('-')[1]

    if (this.parentElement.parentElement.childElementCount>3) {

        this.parentElement.remove()

        let label = document.querySelectorAll('#' + rootID + ' .choice > label')
        let input = document.querySelectorAll('#' + rootID + ' .choice-input')
        let trash = document.querySelectorAll('#' + rootID + ' .choice button')


        for (let i = 1; i <= label.length; i++) {

            label[i - 1].innerHTML = 'Choix ' + i
            label[i - 1].setAttribute('for', 'choice-' + question + i)

            input[i - 1].id = 'choice-' + question + i
            input[i - 1].setAttribute('name', 'choice-' + question + i)

            trash[i - 1].id = 'trash-'+i
            trash[i - 1].addEventListener('click',delChoice)
        }
    }

}


function createSelect(div){

    choice.set(numQuestion,2)

    let divQ = document.createElement("div");
    divQ.innerHTML = '<p>Réponses</p>'+
        '<div id="choice-'+numQuestion+'-1">'+
        '<input id="q'+numQuestion+'-1" type="text" name="q'+numQuestion+'-select1">'+
        '<label id="label-'+numQuestion+'-1" for="q'+numQuestion+'-1">Choix 1</label>'+
        '<button id="trash-'+numQuestion+'-1-select" type="button">Supprimer</button>'+
        '</div>'+

        '<div id="choice-'+numQuestion+'-2">'+
        '<input id="q'+numQuestion+'-2" type="text" name="q'+numQuestion+'-select2">'+
        '<label id="label-'+numQuestion+'-2" for="q'+numQuestion+'-2">Choix 2</label>'+
        '<button id="trash-'+numQuestion+'-2-select" type="button">Supprimer</button>'+
        '</div>'+


        '<button id="q'+numQuestion+'-add-select" type="button" name="'+numQuestion+'">Ajouter</button>'

    div.appendChild(divQ)

    document.getElementById('trash-'+numQuestion+'-1-select').addEventListener('click',delChoice)
    document.getElementById('trash-'+numQuestion+'-2-select').addEventListener('click',delChoice)
    document.getElementById('q'+numQuestion+'-add-select').addEventListener('click',newChoice)
}


function createDate(){
    let question = Number.parseInt(this.id.split("-")[2])
    let div = document.getElementById('date-'+question)
    let value = this.value

    if (value === 'duration'){
        div.innerHTML = '<label>Du :<input type="datetime-local" disabled></label>'+
            '<label>Au :<input type="datetime-local" disabled></label>'
    }

    else{
        div.innerHTML = '<input type="'+value+'" disabled>'
    }
}
