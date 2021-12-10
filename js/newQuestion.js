/*
document.getElementById('new-text').addEventListener('click',newForm)
document.getElementById('new-radio').addEventListener('click',newForm)
document.getElementById('new-checkbox').addEventListener('click',newForm)

const newDate=document.getElementById('new-date')
newDate.addEventListener('click',newForm)*/

/*J'ai déclaré le select en fin de fichier */


let buttonOptions = document.querySelectorAll("#addSection > button");
let selectTypeAdd = "new-checkbox";

const content = document.getElementById("document")
const button = document.getElementById('submit')

let numQuestion = 0
const choice = new Map();


function newQuestion(){ //create a question input with response input in html

    button.removeAttribute('disabled')

    const id = this.value

    addDivElement(id);

    let div = document.getElementById('content-'+numQuestion)


    switch (id){
        case 'new-text':
            let divQ = document.createElement("div");
            divQ.innerHTML = '<label>Réponse'+
                '<input type="text" disabled>'+
                '</label>'

            div.appendChild(divQ)
            break

        case 'new-radio':
            createRadioOrCheckbox('radio', div)
            break

        case 'new-checkbox':
            createRadioOrCheckbox('checkbox', div)
            break

        case 'new-date':
            let divS = document.createElement("div");

            divS.innerHTML = '<p>Réponses</p>'+
                '<select id="q'+numQuestion+'-select" name="q'+numQuestion+'-select">'+
                '<option value="date">Date</option>'+
                '<option value="time">Heure</option>'+
                '<option value="datetime-local">Date-heure</option>'+
                '<option value="duration">Durée</option>'+
                '</select>'+

                '<div id="date-'+numQuestion+'">'+
                '<input type="date" disabled>'+
                '</div>'

            div.appendChild(divS)
            document.getElementById('q'+numQuestion+'-select').addEventListener('change',createDate)
            break
    }

}



/****************************************************/



function addDivElement(id){ //create the div element for the question
    numQuestion++

    let type = id.split("-")[1]
    let div = document.createElement("div")
    div.id = 'form-'+numQuestion+'-'+type

    div.innerHTML = '<div id="content-'+numQuestion+'" class="content">'+
            '<label id="label-'+numQuestion+'" for="q'+numQuestion+'">Question</label>'+
            '<textarea id="q'+numQuestion+'" class="question" name="q'+numQuestion+'" placeholder="Question" required></textarea>'+
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
    document.getElementById('down-'+numQuestion+'-'+type).addEventListener('click',moveQuestion)
    document.getElementById('del-'+numQuestion+'-'+type).addEventListener('click',moveQuestion)
}


function moveQuestion(){
    const id = this.id
    const question = Number.parseInt(id.split('-')[1])
    const type = id.split('-')[2]

    numQuestion--
    if (numQuestion===0){
        button.setAttribute('disabled','')
    }

    if (id.startsWith('del')){
        document.getElementById('form-'+question+'-'+type).remove()

        let q = document.querySelectorAll('div[id^="form-"]')

        q.forEach(e => {

            let numBlock = Number.parseInt(e.id.split("-")[1])
            if (numBlock > question) {

                let typeBlock = e.id.split("-")[2]

                e.id = 'form-'+(numBlock - 1)+'-'+typeBlock

                document.getElementById('content-'+numBlock).id = 'content-'+ (numBlock - 1)

                let label = document.getElementById('label-' + numBlock)
                label.setAttribute('for', 'q' + (numBlock - 1))
                label.id = 'label-' + (numBlock - 1)

                let textArea = document.getElementById('q' + numBlock)
                textArea.id = 'q' + (numBlock - 1)
                textArea.setAttribute('name', textArea.id)

                document.getElementById('up-'+numBlock+'-'+typeBlock).id = 'up-'+(numBlock - 1)+'-'+typeBlock
                document.getElementById('down-'+numBlock+'-'+typeBlock).id = 'down-'+(numBlock - 1)+'-'+typeBlock
                document.getElementById('del-'+numBlock+'-'+typeBlock).id = 'del-'+(numBlock - 1)+'-'+typeBlock



                switch (typeBlock){

                    case 'radio':
                        updateNumRC(numBlock,typeBlock)
                        break

                    case 'checkbox':
                        updateNumRC(numBlock,typeBlock)
                        break

                    case 'date':
                        let select = document.getElementById('q'+numBlock+'-select')
                        select.id = 'q'+(numBlock - 1)+'-select'
                        select.setAttribute('name',select.id)
                        document.getElementById('date-'+numBlock).id = 'date-'+(numBlock - 1)
                        break

                    default:
                        break
                }
            }
        })

    }



    else if (id.startsWith('up') && question > 1){
        let object = document.getElementById('q'+question+'-content')
        let object2 = document.getElementById('q'+(question+1)+'-content')
    }



    else if (id.startsWith('down')){
        document.getElementById('form-'+question+'-'+type)
    }
}


function updateNumRC(numBlock,typeBlock){
    for (let i = 1; i <= choice.get(numBlock); i++) {

        document.getElementById('choice-' + numBlock + '-' + i).id = 'choice-' + (numBlock - 1) + '-' + i

        let label = document.getElementById('label-' + numBlock + '-' + i)
        label.setAttribute('for', 'q' + (numBlock - 1) + '-' + i)
        label.id = 'label-' + (numBlock - 1) + '-' + i

        let input = document.getElementById('q' + numBlock + '-' + i)
        input.setAttribute('name', 'q' + (numBlock - 1) + '-' + typeBlock + i)
        input.id = 'q' + (numBlock - 1) + '-' + i

        let button = document.getElementById('trash-' + numBlock + '-' + i + '-' + typeBlock)
        button.id = 'trash-' + (numBlock - 1) + '-' + i + '-' + typeBlock
        button.addEventListener('click', delChoice)

    }

    let button2 = document.getElementById('q'+numBlock+'-add-'+typeBlock)
    button2.setAttribute('name',(numBlock - 1).toString())
    button2.id = 'q'+(numBlock - 1)+'-add-'+typeBlock
    button2.addEventListener('click',newChoice)
}


function createRadioOrCheckbox(type, div){

    choice.set(numQuestion,2)

    let divQ = document.createElement("div");
    divQ.innerHTML = '<p>Réponses</p>'+
        '<div id="choice-'+numQuestion+'-1">'+
            '<input type="'+type+'" disabled>'+
            '<input id="q'+numQuestion+'-1" type="text" name="q'+numQuestion+'-'+type+'1">'+
            '<label id="label-'+numQuestion+'-1" for="q'+numQuestion+'-1">Choix 1</label>'+
            '<button id="trash-'+numQuestion+'-1-'+type+'" type="button">Supprimer</button>'+
        '</div>'+


        '<div id="choice-'+numQuestion+'-2">'+
            '<input type="'+type+'" disabled>'+
            '<input id="q'+numQuestion+'-2" type="text" name="q'+numQuestion+'-'+type+'2">'+
            '<label id="label-'+numQuestion+'-2" for="q'+numQuestion+'-2">Choix 2</label>'+
            '<button id="trash-'+numQuestion+'-2-'+type+'" type="button">Supprimer</button>'+
        '</div>'+


        '<button id="q'+numQuestion+'-add-'+type+'" type="button" name="'+numQuestion+'">Ajouter</button>'

    div.appendChild(divQ)

    document.getElementById('trash-'+numQuestion+'-1-'+type).addEventListener('click',delChoice)
    document.getElementById('trash-'+numQuestion+'-2-'+type).addEventListener('click',delChoice)
    document.getElementById('q'+numQuestion+'-add-'+type).addEventListener('click',newChoice)
}


function newChoice(){ //add a choice for multi input

    const type = this.id.split("-")[2]
    const question = Number.parseInt(this.getAttribute('name'))

    choice.set(question,choice.get(question)+1)

    const num = choice.get(question)

    const add='<div id="choice-'+question+'-'+num+'">'+
            '<input type="'+type+'" disabled>'+
            '<input id="q'+question+'-'+num+'" type="text" name="q'+question+'-'+type+num+'">'+
            '<label id="label-'+question+'-'+num+'" for="q'+question+'-'+num+'">Choix '+num+'</label>'+
            '<button id="trash-'+question+'-'+num+'-'+type+'" type="button">Supprimer</button>'+
        '</div>'

    this.insertAdjacentHTML("beforebegin", add);

    document.getElementById('trash-'+question+'-'+num+'-'+type).addEventListener('click',delChoice)
}


function delChoice(){ //delete a choice for multi input

    const numQuestion = Number.parseInt(this.id.split("-")[1])
    const numChoice = Number.parseInt(this.id.split("-")[2])
    const typeChoice = this.id.split("-")[3]

    if (choice.get(numQuestion)>1) {

        document.getElementById('choice-' + numQuestion + '-' + numChoice).remove()

        for (let i = numChoice; i < choice.get(numQuestion); i++) {

            let label = document.querySelector('#label-' + numQuestion + '-' + (i + 1))
            label.textContent = 'Choix ' + i
            label.setAttribute('for', 'q' + numQuestion + '-' + i)
            label.id = 'label-' + numQuestion + '-' + i

            document.querySelector('#choice-' + numQuestion + '-' + (i + 1)).id = 'choice-' + numQuestion + '-' + i

            let input = document.querySelector('#q' + numQuestion + '-' + (i + 1))
            input.setAttribute('name', 'q' + numQuestion + '-' + typeChoice + i)
            input.id = 'q' + numQuestion + '-' + i

            let button = document.querySelector('#trash-' + numQuestion + '-' + (i + 1) + '-' + typeChoice)
            button.id = 'trash-' + numQuestion + '-' + i + '-' + typeChoice
            button.addEventListener('click', delChoice)
        }

        choice.set(numQuestion, choice.get(numQuestion) - 1)
    }
}


function createDate(){
    let question = Number.parseInt(this.id.slice(1,2))
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

try {
    buttonOptions.forEach(e => e.addEventListener('click', newQuestion));
} catch (error) {
    console.error(error);
}