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


function createRadioOrCheckbox(type){
    choice.set(numQuestion.toString(),2)

    return '<p>Réponses</p>'+
        '<label for="q'+numQuestion+'-'+type+'1">Choix 1</label>'+
        '<input id="q'+numQuestion+'-'+type+'1" type="text" name="q'+numQuestion+'-'+type+'1">'+
        '<input type="'+type+'" disabled>'+

        '<label for="q'+numQuestion+'-'+type+'2">Choix 2</label>'+
        '<input id="q'+numQuestion+'-'+type+'2" type="text" name="q'+numQuestion+'-'+type+'2">'+
        '<input type="'+type+'" disabled>'+

        '<button id="q'+numQuestion+'-add-'+type+'" type="button" name="'+numQuestion+'">Ajouter</button>'
}


function newChoice(){ //add a choice for radio or checkbox input

    const type = this.getAttribute('id').slice(7)

    const question = this.getAttribute('name')

    choice.set(this.getAttribute('name'),choice.get(this.getAttribute('name'))+1)

    const num = choice.get(this.getAttribute('name'))

    let add='<label for="q'+question+'-'+type+num+'">Choix '+num+'</label>'+
        '<input id="q'+question+'-'+type+num+'" type="text" name="q'+question+'-'+type+num+'">'+
        '<input type="'+type+'" disabled>'

    this.insertAdjacentHTML("beforebegin", add);
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



    let divQ = document.createElement("div");

    if(id === 'new-text'){

        divQ.innerHTML = '<label for="response'+numQuestion+'">Réponse</label>'+
                    '<input id="response'+numQuestion+'" type="text" name="response" disabled>'

        div.appendChild(divQ)
    }

    else if(id === 'new-radio'){

        divQ.innerHTML = createRadioOrCheckbox('radio')

        div.appendChild(divQ)
        document.querySelector('#q'+numQuestion+'-add-radio').addEventListener('click',newChoice)
    }

    else if(id === 'new-checkbox'){

        divQ.innerHTML = createRadioOrCheckbox('checkbox')

        div.appendChild(divQ)
        document.querySelector('#q'+numQuestion+'-add-checkbox').addEventListener('click',newChoice)
    }

}
