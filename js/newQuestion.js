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


function newForm(){ //create a question input with response input in html

    let xhr1 = new XMLHttpRequest()


    xhr1.onreadystatechange = function() {
        console.log(this)
        if (this.readyState === 4 && this.status === 200)
        {

            addDivElement().innerHTML = this.responseText
            button.removeAttribute('disabled')

        }
        else if (this.readyState === 4 && this.status === 404)
        {
            alert('Erreur chargement')
        }
    }

    numQuestion++

    let data = 'numQuestion=' + numQuestion + '&id=' + this.getAttribute('id')

    xhr1.open("POST", "/modules/newQuestion.php")
    xhr1.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr1.send(data)
    /*xhr1.onload = () => {
        console.log(xhr1.responseText);
    }*/

    if (this.getAttribute('id') === 'new-radio'){
        const addRadio=document.querySelectorAll('.b-add-radio')
        for (i=0;i<addRadio.length;i++){
            addRadio.addEventListener('click',newChoice)
        }
/*        addRadio.forEach((element,index) => {
            index.addEventListener('click',newChoice)
        })*/

    }
    else if (this.getAttribute('id') === 'new-checkbox'){
        const addCheckbox=document.querySelectorAll('.b-add-checkbox')
        addCheckbox.addEventListener('click',newChoice)
    }

}


function addDivElement(){ //create the div element for the question
    numForm++
    let div = document.createElement("div")
    content.appendChild(div)
    div.setAttribute('id', 'form'+numForm)

    return div
}


/*------------------------------*/






function newChoice(){ //add a choice for radio or checkbox input

    let xhr2 = new XMLHttpRequest()

    let h = this


    xhr2.onreadystatechange = function() {
        console.log(this)
        if (this.readyState === 4 && this.status === 200)
        {
            h.insertAdjacentHTML("beforebegin", this.responseText);
        }
        else if (this.readyState === 4 && this.status === 404)
        {
            alert('Erreur chargement')
        }
    }

    let data = 'numQuestion=' + numQuestion + '&class=' + this.getAttribute("class")

    xhr2.open("POST", "/modules/newChoice.php")
    xhr2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr2.send(data)
    /*xhr2.onload = () => {
        console.log(xhr2.responseText);
    }*/
}