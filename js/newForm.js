const newElement=document.getElementById('new-element')
newElement.addEventListener('click',newForm)

const content = document.getElementById("form-document")
const button = document.getElementById('submit')

let nbForms = 1

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

    xhr.open("GET", "/modules/baseNewForm.php", true)
    xhr.send()
}


function addDivElement(){
    let div = document.createElement("div")
    content.appendChild(div)
    div.setAttribute('id', 'form'+nbForms)
    nbForms++

    return div
}
