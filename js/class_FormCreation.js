class FormCreation {
    static buttonOptions = document.querySelectorAll("#addSection > button");
    static CONTENT = document.getElementById('form-content')
    static button = document.getElementById('submit')
    static numQuestion = 0
    static selectedQuestion = null

    constructor() {
        FormCreation.buttonOptions.forEach(e => e.addEventListener('click', FormCreation.newBloc))
        FormCreation.newPage()
        document.getElementById("ClearForm").addEventListener('click', FormCreation.resetForm)
    }


    static resetForm() {
        FormCreation.CONTENT.innerHTML = ''
        FormCreation.numQuestion = 0
        FormCreation.button.setAttribute('disabled', '')
        FormCreation.newPage()
    }


    static newPage(){
        let page=document.createElement("div")
        page.className = 'page'
        FormCreation.CONTENT.appendChild(page)
    }


    static newBloc(qValue, choiceArray){ //create a question input

        FormCreation.button.removeAttribute('disabled')

        let id, title, required
        if (typeof(qValue["id"]) == "undefined") {
            title = ""
            id = this.id
            required = ""
        }
        else {
            id = 'new-' + qValue["type"]
            title = qValue["title"]
            if (qValue["required"] == 1)
                required = "checked"
            else
                required = ""
        }


        function addDivElement(id){ //create the bloc for the question
            FormCreation.numQuestion++

            let type = id.split("-")[1]
            let div = document.createElement("div")
            div.id = 'form-'+FormCreation.numQuestion+'-'+type
            div.className = 'question-bloc'
            div.addEventListener("click",FormCreation.selectQuestion)
            div.addEventListener("blur",FormCreation.selectQuestion)

            div.innerHTML = '<div class="content">'+
                '<label>Question ('+type+')'+
                '<textarea class="question" name="q'+FormCreation.numQuestion+'" placeholder="Question" required></textarea>'+
                '</label>'+
                '</div>'+

                '<label class="required">Requis<input type="checkbox" name="required-'+FormCreation.numQuestion+'" '+required+'></label>'+

                '<div class="move">'+
                '<button id="up-'+FormCreation.numQuestion+'-'+type+'" type="button">'+
                '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">'
                +'<path fill-rule="evenodd" clip-rule="evenodd" d="M11.0001 22.2877H13.0001V7.80237L16.2428 11.045L17.657 9.63079L12.0001 3.97394L6.34326 9.63079L7.75748 11.045L11.0001 7.80236V22.2877ZM18 3H6V1H18V3Z" fill="currentColor" />'
                +'</svg>'
                +'</button>'+
                '<button id="del-'+FormCreation.numQuestion+'-'+type+'" type="button">'+
                '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">'
                +'<path d="M16.3956 7.75734C16.7862 8.14786 16.7862 8.78103 16.3956 9.17155L13.4142 12.153L16.0896 14.8284C16.4802 15.2189 16.4802 15.8521 16.0896 16.2426C15.6991 16.6331 15.0659 16.6331 14.6754 16.2426L12 13.5672L9.32458 16.2426C8.93405 16.6331 8.30089 16.6331 7.91036 16.2426C7.51984 15.8521 7.51984 15.2189 7.91036 14.8284L10.5858 12.153L7.60436 9.17155C7.21383 8.78103 7.21383 8.14786 7.60436 7.75734C7.99488 7.36681 8.62805 7.36681 9.01857 7.75734L12 10.7388L14.9814 7.75734C15.372 7.36681 16.0051 7.36681 16.3956 7.75734Z" fill="currentColor" />'
                +'<path fill-rule="evenodd" clip-rule="evenodd" d="M4 1C2.34315 1 1 2.34315 1 4V20C1 21.6569 2.34315 23 4 23H20C21.6569 23 23 21.6569 23 20V4C23 2.34315 21.6569 1 20 1H4ZM20 3H4C3.44772 3 3 3.44772 3 4V20C3 20.5523 3.44772 21 4 21H20C20.5523 21 21 20.5523 21 20V4C21 3.44772 20.5523 3 20 3Z" fill="currentColor" />'
                +'</svg>'
                +'</button>'+
                '<button id="down-'+FormCreation.numQuestion+'-'+type+'" type="button">'+
                '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">'
                +'<path d="M11.0001 1H13.0001V15.4853L16.2428 12.2427L17.657 13.6569L12.0001 19.3137L6.34326 13.6569L7.75748 12.2427L11.0001 15.4853V1Z" fill="currentColor" />'
                +'<path d="M18 20.2877H6V22.2877H18V20.2877Z" fill="currentColor" />'
                +'</svg>'
                +'</button>'+
                '</div>'

            if (FormCreation.selectedQuestion != null && FormCreation.selectedQuestion.className === 'question-bloc')
                FormCreation.selectedQuestion.insertAdjacentElement("afterend", div)
            else
                FormCreation.CONTENT.lastElementChild.insertAdjacentElement("beforeend", div)
            document.getElementById('up-'+FormCreation.numQuestion+'-'+type).addEventListener('click',FormCreation.moveQuestion)
            document.getElementById('del-'+FormCreation.numQuestion+'-'+type).addEventListener('click',FormCreation.moveQuestion)
            document.getElementById('down-'+FormCreation.numQuestion+'-'+type).addEventListener('click',FormCreation.moveQuestion)

            return div
        }

        let bloc = addDivElement(id).id;

        document.querySelector('#'+bloc+' .question').value = title


        let div = document.querySelector('#'+bloc+' .content')

        switch (id){

            case 'new-number':
                div.appendChild(FormCreation.createRangeInput())
                break

            case 'new-range':
                div.appendChild(FormCreation.createRangeInput())
                break

            case 'new-radio':
            case 'new-checkbox':
                FormCreation.createRadioOrCheckbox(id.split('-')[1], div, choiceArray)
                break

            case 'new-select':
                FormCreation.createSelect(div, choiceArray)
                break

            case 'new-date':
                let divD = document.createElement("div");

                divD.innerHTML =
                    '<select id="select-date-'+FormCreation.numQuestion+'" name="select-date-'+FormCreation.numQuestion+'">'+
                    '<option value="date">Date</option>'+
                    '<option value="time">Heure</option>'+
                    '<option value="datetime-local">Date-heure</option>'+
                    '<option value="duration">Durée</option>'+
                    '</select>'+

                    '<div id="date-'+FormCreation.numQuestion+'">'+
                    '<input type="date" disabled>'+
                    '</div>'

                div.appendChild(divD)
                document.getElementById('select-date-'+FormCreation.numQuestion).addEventListener('change',FormCreation.createDate)
                break

            case 'new-textarea':
                FormCreation.createTextarea(div)
                break

            default:
                div.appendChild(FormCreation.createSimpleInput(id.split('-')[1]))
                break
        }

    }


    static selectQuestion(){
        if (FormCreation.selectedQuestion != null){
            if (FormCreation.selectedQuestion.style.border !== "none")
            FormCreation.selectedQuestion.style.border = "none"
        }
        FormCreation.selectedQuestion = this
        FormCreation.selectedQuestion.style.border = "2px solid var(--first)"
        FormCreation.selectedQuestion.style.boxSizing = "border-box"
    }


    static verification(index = 0){

        let allQuestions = document.querySelectorAll('#form-content div[id^="form-"]')
        FormCreation.numQuestion = allQuestions.length

        if (index < FormCreation.numQuestion) {

            for (let i = index; i < allQuestions.length; i++) {
                let num = i + 1
                let type = allQuestions[i].id.split("-")[2]

                allQuestions[i].id = 'form-' + num + '-' + type
                let root = allQuestions[i].id

                document.querySelector('#' + root + ' .question').setAttribute('name', 'q' + num)
                document.querySelector('#' + root + ' .required input').setAttribute('name', 'required-' + num)

                let move = document.querySelectorAll('#' + root + ' .move button')
                move[0].id = 'up-' + num + '-' + type
                move[1].id = 'del-' + num + '-' + type
                move[2].id = 'down-' + num + '-' + type


                switch (type) {

                    case 'range':
                        let value = document.querySelectorAll('#' + root + ' .content input[type="text"]')
                        value[0].id = 'choice-' + num + '1'
                        value[0].setAttribute('name', value[0].id)
                        value[1].id = 'choice-' + num + '2'
                        value[1].setAttribute('name', value[1].id)
                        break

                    case 'radio':
                    case 'checkbox':
                    case 'select':
                        FormCreation.updateNumRC(num, type, 0)
                        break

                    case 'date':
                        let select = document.querySelector('#' + root + ' .content div select')
                        select.id = 'select-date-' + num
                        select.setAttribute('name', select.id)
                        document.querySelector('#' + root + ' .content div div').id = 'date-' + num
                        break

                    default:
                        break
                }
            }
        }

    }


    static moveQuestion(){
        const id = this.id
        const question = Number.parseInt(id.split('-')[1])
        const type = id.split('-')[2]
        let current = document.getElementById('form-'+question+'-'+type)


        if (id.startsWith('del')){
            current.remove()
            FormCreation.numQuestion--

            if (FormCreation.numQuestion===0){
                FormCreation.button.setAttribute('disabled','')
            }else {
                FormCreation.verification(question-1)
            }

        }

        else if (id.startsWith('up') && (question-1) > 0){
            let node = document.querySelector('div[id^="form-'+(question-1)+'"]')
            FormCreation.swapNodes(node, current)
        }

        else if (id.startsWith('down') && question < FormCreation.numQuestion){
            let node = document.querySelector('div[id^="form-'+(question+1)+'"]')
            FormCreation.swapNodes(current, node)
        }
    }


    static updateNumRC(numBlock,typeBlock,j){

        let update = numBlock+j

        let label = document.querySelectorAll('#form-' + update + '-' + typeBlock + ' .choice > label')
        let input = document.querySelectorAll('#form-' + update + '-' + typeBlock + ' .choice-input')
        let trash = document.querySelectorAll('#form-' + update + '-' + typeBlock + ' .choice > button')

        for (let i = 1; i <= label.length; i++) {

            label[i - 1].setAttribute('for', 'choice-' + update + i)

            input[i - 1].id = 'choice-' + update + i
            input[i - 1].setAttribute('name', 'choice-' + update + i)

            trash[i - 1].id = 'trash-' + update + i
            trash[i - 1].addEventListener('click',FormCreation.delChoice)
        }
    }


    static swapNodes(node1, node2) {

        let node2_copy = node2.cloneNode(true);
        node1.parentNode.insertBefore(node2_copy, node1);
        node2.parentNode.insertBefore(node1, node2);
        node2.parentNode.replaceChild(node2, node2_copy);

        let num = Number.parseInt(node1.id.split("-")[1])

        FormCreation.verification(num-1)
    }


    static createSimpleInput(type){
        let div = document.createElement("div");
        div.innerHTML =
            '<input type="'+type+'" placeholder="Ecrire ici..." disabled>'+
            '</label>'
        return div
    }


    static createRangeInput(){
        let div = document.createElement("div");
        div.innerHTML =
            '<input id="choice-'+FormCreation.numQuestion+'1" class="choice-input" type="text" name="choice-'+FormCreation.numQuestion+'1">'+
            '<input type="range">'+
            '<input id="choice-'+FormCreation.numQuestion+'2" class="choice-input" type="text" name="choice-'+FormCreation.numQuestion+'2">'

        return div
    }


    static createRadioOrCheckbox(type, div, choiceArray){

        let divQ = document.createElement("div")

        if (typeof(choiceArray) == "object") {
            let i=1
            choiceArray.forEach(c => {
                if (c["id_question"] == FormCreation.numQuestion) {
                    let tmp =
                        '<div class="choice">' +
                        '<input type="' + type + '" disabled>' +
                        '<label for="choice-' + FormCreation.numQuestion + i + '">Option ' + i + '</label>' +
                        '<input id="choice-' + FormCreation.numQuestion + i + '" class="choice-input" type="text" name="choice-' + FormCreation.numQuestion + i + '" value="' + c["description"] + '">' +
                        '<button id="trash-' + FormCreation.numQuestion + i + '" type="button">Supprimer</button>' +
                        '</div>'

                    divQ.insertAdjacentHTML("beforeend", tmp);
                    i++
                }
            })

            divQ.insertAdjacentHTML("beforeend", '<button class="add-' + type + '" type="button">Ajouter</button>')
            div.appendChild(divQ)
            for (let j=1;j<i;j++) {
                document.getElementById('trash-' + FormCreation.numQuestion + j).addEventListener('click', FormCreation.delChoice)
            }
        }

        else{
            divQ.innerHTML =
                '<div class="choice">' +
                '<input type="' + type + '" disabled>' +
                '<label for="choice-' + FormCreation.numQuestion + '1">Option 1</label>' +
                '<input id="choice-' + FormCreation.numQuestion + '1" class="choice-input" type="text" name="choice-' + FormCreation.numQuestion + '1">' +
                '<button id="trash-' + FormCreation.numQuestion + '1" type="button">Supprimer</button>' +
                '</div>' +

                '<div class="choice">' +
                '<input type="' + type + '" disabled>' +
                '<label for="choice-' + FormCreation.numQuestion + '2">Option 2</label>' +
                '<input id="choice-' + FormCreation.numQuestion + '2" class="choice-input" type="text" name="choice-' + FormCreation.numQuestion + '2">' +
                '<button id="trash-' + FormCreation.numQuestion + '2" type="button">Supprimer</button>' +
                '</div>' +

                '<button class="add-' + type + '" type="button">Ajouter</button>'

            div.appendChild(divQ)

            document.getElementById('trash-'+FormCreation.numQuestion+'1').addEventListener('click',FormCreation.delChoice)
            document.getElementById('trash-'+FormCreation.numQuestion+'2').addEventListener('click',FormCreation.delChoice)
        }

        document.querySelector('#'+div.parentElement.id+' .add-'+type).addEventListener('click',FormCreation.newChoice)
    }


    static createSelect(div, choiceArray){

        let divQ = document.createElement("div");

        if (typeof(choiceArray) == "object") {
            divQ.insertAdjacentHTML("beforeend", '<select><option>Options...</option></select>')
            let i=1
            choiceArray.forEach(c => {
                if (c["id_question"] == numQuestion) {
                    let tmp =
                        '<div class="choice">' +
                        '<input id="choice-' + FormCreation.numQuestion + i + '" class="choice-input" type="text" name="choice-' + FormCreation.numQuestion + i + '" value="' + c["description"] + '">' +
                        '<button id="trash-' + FormCreation.numQuestion + i + '" type="button">Supprimer</button>' +
                        '</div>'

                    divQ.insertAdjacentHTML("beforeend", tmp);
                    i++
                }
            })

            divQ.insertAdjacentHTML("beforeend", '<button class="add-select" type="button">Ajouter</button>')
            div.appendChild(divQ)
            for (let j=1;j<i;j++) {
                document.getElementById('trash-' + FormCreation.numQuestion + j).addEventListener('click', FormCreation.delChoice)
            }
        }

        else {
            divQ.innerHTML =
                '<select><option>Choisir...</option></select>' +

                '<div class="choice">' +
                '<input id="choice-' + FormCreation.numQuestion + '1" class="choice-input" type="text" name="choice-' + FormCreation.numQuestion + '1">' +
                '<button id="trash-' + FormCreation.numQuestion + '1" type="button">Supprimer</button>' +
                '</div>' +

                '<div class="choice">' +
                '<input id="choice-' + FormCreation.numQuestion + '2" class="choice-input" type="text" name="choice-' + FormCreation.numQuestion + '2">' +
                '<button id="trash-' + FormCreation.numQuestion + '2" type="button">Supprimer</button>' +
                '</div>' +

                '<button class="add-select" type="button">Ajouter</button>'

            div.appendChild(divQ)

            document.getElementById('trash-' + FormCreation.numQuestion + '1').addEventListener('click', FormCreation.delChoice)
            document.getElementById('trash-' + FormCreation.numQuestion + '2').addEventListener('click', FormCreation.delChoice)
        }

        document.querySelector('#'+div.parentElement.id+' .add-select').addEventListener('click', FormCreation.newChoice)
    }


    static newChoice(){ //add a choice for multi input

        let type = this.className.split("-")[1]
        let question = this.closest('.content').parentElement.id.split('-')[1]
        let num

        let add
        if (type === 'select'){
            num = this.parentElement.childElementCount - 1

            add='<div class="choice">'+
                '<input id="choice-'+question+num+'" class="choice-input" type="text" name="choice-'+question+num+'">'+
                '<button id="trash-'+question+num+'" type="button">Supprimer</button>'+
                '</div>'
        }

        else {
            num = this.parentElement.childElementCount

            add = '<div class="choice">' +
                '<input type="' + type + '" disabled>' +
                '<label for="choice-' + question + num + '">Option ' + num + '</label>' +
                '<input id="choice-' + question + num + '" class="choice-input" type="text" name="choice-' + question + num + '">' +
                '<button id="trash-' + question + num + '" type="button">Supprimer</button>' +
                '</div>'
        }

        this.insertAdjacentHTML("beforebegin", add);

        document.getElementById('trash-'+question+num).addEventListener('click', FormCreation.delChoice)
    }


    static delChoice(){ //delete a choice for multi input

        let rootID = this.closest('.content').parentElement.id
        let question = rootID.split('-')[1]

        if (this.parentElement.parentElement.childElementCount>2) {

            this.parentElement.remove()

            let label
            if (rootID.split('-')[2] !== "select") {
                label = document.querySelectorAll('#' + rootID + ' .choice > label')
            }
            let input = document.querySelectorAll('#' + rootID + ' .choice-input')
            let trash = document.querySelectorAll('#' + rootID + ' .choice > button')


            for (let i = 1; i <= input.length; i++) {

                if (rootID.split('-')[2] !== "select") {
                    label[i - 1].innerHTML = 'Option ' + i
                    label[i - 1].setAttribute('for', 'choice-' + question + i)
                }

                input[i - 1].id = 'choice-' + question + i
                input[i - 1].setAttribute('name', 'choice-' + question + i)

                trash[i - 1].id = 'trash-'+question+i
                trash[i - 1].addEventListener('click',FormCreation.delChoice)
            }
        }

    }


    static createDate(){
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


    static createTextarea(div){
        let divT = document.createElement("div")
        divT.innerHTML =
            '<textarea disabled placeholder="Ecrire ici..."></textarea>'

        div.appendChild(divT)
    }

}


let obj=new FormCreation()