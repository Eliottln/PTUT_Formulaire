class Class_FormCreation {
    buttonOptions = document.querySelectorAll("#addSection > button");
    CONTENT = document.getElementById('form-content')
    button = document.getElementById('submit')
    numQuestion = 0
    selectedQuestion

    constructor() {
        this.buttonOptions.forEach(e => e.addEventListener('click', newBloc));
        this.newPage()
    }

    newPage(){
        let page=document.createElement("div")
        page.className = 'page'
        this.CONTENT.appendChild(page)
    }

    newBloc(qValue, choiceArray){ //create a question input

        this.button.removeAttribute('disabled')

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

        let bloc = addDivElement(id).id;

        document.querySelector('#'+bloc+' .question').value = title


        let div = document.querySelector('#'+bloc+' .content')

        switch (id){

            case 'new-number':
                div.appendChild(createRangeInput())
                break

            case 'new-range':
                div.appendChild(createRangeInput())
                break

            case 'new-radio':
            case 'new-checkbox':
                createRadioOrCheckbox(id.split('-')[1], div, choiceArray)
                break

            case 'new-select':
                createSelect(div, choiceArray)
                break

            case 'new-date':
                let divD = document.createElement("div");

                divD.innerHTML =
                    '<select id="select-date-'+numQuestion+'" name="select-date-'+numQuestion+'">'+
                    '<option value="date">Date</option>'+
                    '<option value="time">Heure</option>'+
                    '<option value="datetime-local">Date-heure</option>'+
                    '<option value="duration">Durée</option>'+
                    '</select>'+

                    '<div id="date-'+numQuestion+'">'+
                    '<input type="date" disabled>'+
                    '</div>'

                div.appendChild(divD)
                document.getElementById('select-date-'+numQuestion).addEventListener('change',createDate)
                break

            case 'new-textarea':
                createTextarea(div)
                break

            default:
                div.appendChild(createSimpleInput(id.split('-')[1]))
                break
        }

    }
    //create the bloc for the question
    addDivElement(id){ //create the div element for the question
        numQuestion++

        let type = id.split("-")[1]
        let div = document.createElement("div")
        div.id = 'form-'+numQuestion+'-'+type

        div.innerHTML = '<div class="content">'+
            '<label>Question ('+type+')'+
            '<textarea class="question" name="q'+numQuestion+'" placeholder="Question" required></textarea>'+
            '</label>'+
            '</div>'+

            '<label class="required">Requis<input type="checkbox" name="required-'+numQuestion+'" '+required+'></label>'+

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

        if (this.selectedQuestion)
            content.appendChild(div)
        document.getElementById('up-'+numQuestion+'-'+type).addEventListener('click',moveQuestion)
        document.getElementById('del-'+numQuestion+'-'+type).addEventListener('click',moveQuestion)
        document.getElementById('down-'+numQuestion+'-'+type).addEventListener('click',moveQuestion)

        return div
    }
}
