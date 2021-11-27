const newText=document.getElementById('new-text')
newText.addEventListener('click',newForm)

const newRadio=document.getElementById('new-radio')
newRadio.addEventListener('click',newForm)

const newCheckbox=document.getElementById('new-checkbox')
newCheckbox.addEventListener('click',newForm)

const content = document.getElementById("form-document")
const button = document.getElementById('submit')

let numQuestion = 0
const choice = new Map();


function addDivElement(id){ //create the div element for the question
    numQuestion++

    let div = document.createElement("div")
    content.appendChild(div)
    div.setAttribute('id', 'form-'+numQuestion+'-'+id.slice(4))

    return div
}


function createRadioOrCheckbox(type, div){

    choice.set(numQuestion,2)

    let divQ = document.createElement("div");
    divQ.innerHTML = '<p>Réponses</p>'+
        '<div id="choice-'+numQuestion+'-1">'+
            '<input type="'+type+'" disabled>'+
            '<input id="q'+numQuestion+'-1" type="text" name="q'+numQuestion+'-'+type+'1">'+
            '<label for="'+numQuestion+'-1">Choix 1</label>'+
        '</div>'+
        '<button id="trash'+numQuestion+'-1-'+type+'" type="button">Supprimer</button>'+

        '<div id="choice-'+numQuestion+'-2">'+
            '<input type="'+type+'" disabled>'+
            '<input id="q'+numQuestion+'-2" type="text" name="q'+numQuestion+'-'+type+'2">'+
            '<label for="'+numQuestion+'-2">Choix 2</label>'+
        '</div>'+
        '<button id="trash'+numQuestion+'-2-'+type+'" type="button">Supprimer</button>'+

        '<button id="q'+numQuestion+'-add-'+type+'" type="button" name="'+numQuestion+'">Ajouter</button>'

    div.appendChild(divQ)

    document.querySelector('#trash'+numQuestion+'-1-'+type).addEventListener('click',delChoice)
    document.querySelector('#trash'+numQuestion+'-2-'+type).addEventListener('click',delChoice)
    document.querySelector('#q'+numQuestion+'-add-'+type).addEventListener('click',newChoice)
}


function newChoice(){ //add a choice for multi input

    const type = this.getAttribute('id').slice(7)

    const question = this.getAttribute('name')

    const index = Number.parseInt(question.toString())

    choice.set(index,choice.get(index)+1)

    const num = choice.get(index)

    const add='<div id="choice-'+question+'-'+num+'">'+
            '<input type="'+type+'" disabled>'+
            '<input id="q'+question+'-'+num+'" type="text" name="q'+question+'-'+type+num+'">'+
            '<label for="q'+question+'-'+num+'">Choix '+num+'</label>'+
        '</div>'+
        '<button id="trash'+question+'-'+num+'-'+type+'" type="button">Supprimer</button>'

    this.insertAdjacentHTML("beforebegin", add);

    document.querySelector('#trash'+question+'-'+num+'-'+type).addEventListener('click',delChoice)
}


function delChoice(){ //delete a choice for multi input

    const id = this.getAttribute('id')

    const numQuestion = Number.parseInt(id.slice(5,6))
    const numChoice = Number.parseInt(id.slice(7,8))
    const typeChoice = id.slice(9)

    if (choice.get(numQuestion)>1) {

        document.querySelector('#choice-' + numQuestion + '-' + numChoice).remove()

        this.remove()

        for (let i = numChoice; i < choice.get(numQuestion); i++) {

            let label = document.querySelector('#choice-' + numQuestion + '-' + (i + 1) + ' label')
            label.textContent = 'Choix ' + i
            label.setAttribute('for', 'q' + numQuestion + '-' + i)

            let divBlock = document.querySelector('#choice-' + numQuestion + '-' + (i + 1))
            divBlock.setAttribute('id', 'choice-' + numQuestion + '-' + i)

            let input = document.querySelector('#q' + numQuestion + '-' + (i + 1))
            input.setAttribute('name', 'q' + numQuestion + '-' + typeChoice + i)
            input.setAttribute('id', 'q' + numQuestion + '-' + i)

            let button = document.querySelector('#trash' + numQuestion + '-' + (i + 1) + '-' + typeChoice)
            button.setAttribute('id', 'trash' + numQuestion + '-' + i + '-' + typeChoice)

            button.addEventListener('click', delChoice)
        }

        choice.set(numQuestion, choice.get(numQuestion) - 1)

    }
}



/****************************************************/



function newForm(){ //create a question input with response input in html

    button.removeAttribute('disabled')

    const id = this.getAttribute('id')

    let div = addDivElement(id)

    //Create the textarea for the question
    div.innerHTML = '<div>'+
                        '<label for="q'+numQuestion+'">Question</label>'+
                        '<textarea id="q'+numQuestion+'" class="question" name="q'+numQuestion+'" placeholder="Question" required></textarea>'+
                    '</div>'



    switch (id){
        case 'new-text':
            let divQ = document.createElement("div");
            divQ.innerHTML = '<label for="response'+numQuestion+'">Réponse</label>'+
                '<input id="response'+numQuestion+'" type="text" name="response" disabled>'

            div.appendChild(divQ)
            break

        case 'new-radio':
            createRadioOrCheckbox('radio', div)
            break

        case 'new-checkbox':
            createRadioOrCheckbox('checkbox', div)
            break
    }

    // if(id === 'new-text'){
    //     let divQ = document.createElement("div");
    //     divQ.innerHTML = '<label for="response'+numQuestion+'">Réponse</label>'+
    //                 '<input id="response'+numQuestion+'" type="text" name="response" disabled>'
    //
    //     div.appendChild(divQ)
    // }
    //
    // else if(id === 'new-radio'){
    //     createRadioOrCheckbox('radio', div)
    // }
    //
    // else if(id === 'new-checkbox'){
    //     createRadioOrCheckbox('checkbox', div)
    // }

}
