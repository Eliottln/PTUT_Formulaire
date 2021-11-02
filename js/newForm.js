const newElement=document.getElementById('new-element')
newElement.addEventListener('click',newForm)

let content = document.getElementById("form-document")

let nbForms = 1

function newForm(){
    let xhr = new XMLHttpRequest()

    xhr.onreadystatechange = function() {
        console.log(this)
        if (this.readyState === 4 && this.status === 200)
        {
            addDivElement().innerHTML = this.responseText
        }
        else if (this.readyState === 4 && this.status === 404)
        {
            alert('Erreur chargement')
        }
    }

    xhr.open("GET", "/php/Form.php", true)
    xhr.send()
}


function addDivElement(){
    let div = document.createElement("div")
    content.appendChild(div)
    div.setAttribute('id', 'form'+nbForms)
    nbForms++

    return div
}
