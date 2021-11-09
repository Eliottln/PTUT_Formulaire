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


function newForm(){

    let xhr = new XMLHttpRequest()

    xhr.onreadystatechange = function() {
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

    xhr.open("POST", "/modules/newQuestion.php")
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(data)
    xhr.onload = () => {
        console.log(xhr.responseText);
    }
}


function addDivElement(){
    numForm++
    let div = document.createElement("div")
    content.appendChild(div)
    div.setAttribute('id', 'form'+numForm)

    return div
}
