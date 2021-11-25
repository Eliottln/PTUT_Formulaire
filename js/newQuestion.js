const newText=document.getElementById('new-text')
newText.addEventListener('click',newForm)

const newRadio=document.getElementById('new-radio')
newRadio.addEventListener('click',newForm)

const newCheckbox=document.getElementById('new-checkbox')
newCheckbox.addEventListener('click',newForm)


const content = document.getElementById("form-document")

const button = document.getElementById('submit')

let numForm = 0
let numQuestion = 0


function addDivElement(){ //create the div element for the question
    numForm++
    let div = document.createElement("div")
    content.appendChild(div)
    div.setAttribute('id', 'form'+numForm)

    return div
}



function newForm(){ //create a question input with response input in html

    button.removeAttribute('disabled')

    numQuestion++

    let div = addDivElement()

    div.innerHTML = '<div>'+
                        '<label for="question-num'+numQuestion+'">Question</label>'+
                        '<textarea id="question-num'+numQuestion+'" class="question" name="question-num'+numQuestion+'" placeholder="Question" required></textarea>'+
                    '</div>'

    if(this.getAttribute('id') === 'new-text'){

        let divQ = document.createElement("div");
        divQ.innerHTML = '<label for="response-text">Réponse</label>'+
                    '<input id="response-text" type="text" name="response" disabled>'

        div.appendChild(divQ)
    }

    else if(this.getAttribute('id') === 'new-radio'){

        let divQ = document.createElement("div");
        divQ.innerHTML = '<p>Réponses</p>'+
                    '<label for="q'+numQuestion+'-radio-choice1">Choix 1</label>'+
                    '<input id="q'+numQuestion+'-radio-choice1" type="text" name="q'+numQuestion+'-radio-choice1">'+
                    '<input type="radio" name="q'+numQuestion+'-response" disabled>'+

                    '<label for="q'+numQuestion+'-radio-choice2">Choix 2</label>'+
                    '<input id="q'+numQuestion+'-radio-choice2" type="text" name="q'+numQuestion+'-radio-choice2">'+
                    '<input type="radio" name="q'+numQuestion+'-response" disabled>'+

                    '<button id="q'+numQuestion+'-button-add-radio" type="button">Ajouter</button>'

        div.appendChild(divQ)

        const addCheckbox=document.querySelector('#q'+numQuestion+'-button-add-radio')
        addCheckbox.addEventListener('click',newChoice)
    }

    else if(this.getAttribute('id') === 'new-checkbox'){

        let divQ = document.createElement("div");
        divQ.innerHTML = '<p>Réponses</p>'+
            '<label for="q'+numQuestion+'-checkbox-choice1">Choix 1</label>'+
            '<input id="q'+numQuestion+'-checkbox-choice1" type="text" name="q'+numQuestion+'-checkbox-choice1">'+
            '<input type="checkbox" name="q'+numQuestion+'-response" disabled>'+

            '<label for="q'+numQuestion+'-checkbox-choice2">Choix 2</label>'+
            '<input id="q'+numQuestion+'-checkbox-choice2" type="text" name="q'+numQuestion+'-checkbox-choice2">'+
            '<input type="checkbox" name="q'+numQuestion+'-response" disabled>'+

            '<button id="q'+numQuestion+'-button-add-checkbox" type="button">Ajouter</button>'

        div.appendChild(divQ)

        const addCheckbox=document.querySelector('#q'+numQuestion+'-button-add-checkbox')
        addCheckbox.addEventListener('click',newChoice)
    }

}


/*------------------------------*/


function newChoice(){ //add a choice for radio or checkbox input

    const regex = /radio/

    if(regex.test(this.getAttribute('id'))){
        let choice='<label for="q'+numQuestion+'-radio-choice3">Choix 3</label>'+
                '<input id="q'+numQuestion+'-radio-choice3" type="text" name="q'+numQuestion+'-radio-choice3">'+
                '<input id="response-radio3" type="radio" name="q'+numQuestion+'-response" disabled>'

        this.insertAdjacentHTML("beforebegin", choice);
    }
    else{
        let choice='<label for="q'+numQuestion+'-checkbox-choice3">Choix 3</label>'+
            '<input id="q'+numQuestion+'-checkbox-choice3" type="text" name="q'+numQuestion+'-checkbox-choice3">'+
            '<input id="response-checkbox3" type="checkbox" name="q'+numQuestion+'-response" disabled>'

        this.insertAdjacentHTML("beforebegin", choice);
    }

}