document.getElementById('new-text').addEventListener('click',newQuestion)
document.getElementById('new-radio').addEventListener('click',newQuestion)
document.getElementById('new-checkbox').addEventListener('click',newQuestion)
document.getElementById('new-date').addEventListener('click',newQuestion)

const content = document.getElementById("document")
const button = document.getElementById('submit')

let numQuestion = 0
const choice = new Map();


function newQuestion(){ //create a question input with response input in html

    button.removeAttribute('disabled')

    const id = this.id

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
            '<button id="up-'+numQuestion+'-'+type+'" type="button">Up</button>'+
            '<button id="down-'+numQuestion+'-'+type+'" type="button">Down</button>'+
            '<button id="del-'+numQuestion+'-'+type+'" type="button">Supprimer</button>'+
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
