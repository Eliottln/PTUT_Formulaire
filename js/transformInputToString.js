const formTemp = document.getElementById('export')
document.getElementById('submit').addEventListener('click', addInput)


/*******************************
 * 
 * forme des questions
 * 
 * choix unique : type/titre
 * 
 * choix multiple : type/titre/nombreDeChoix/titreChoix1/titreChoix2/titreChoix3/...
 * 
 *
*/

function addInput() {

    let tabInput = []
    let n = 1
    let allPage = document.querySelectorAll('#form-content .page')

    //AJOUTE LES CHOIX AU QUESTION
    function addTabChoice(type, question) {
        let string = "";

        switch (type) {
            case "radio":
            case "checkbox":
            case "select": //FIXME
                let choicesList = question.firstElementChild.lastElementChild.children
                let nb_choices = (choicesList.length - 1)
                string += '/' + nb_choices
                for (let index = 0; index < nb_choices; index++) {
                    string += '/' + choicesList[index].children[2].value
                }
                break;

            case "number":
            case "range":
                let min = question.firstElementChild.lastElementChild.children[0].value;  //target min
                let max = question.firstElementChild.lastElementChild.children[2].value; //target max
                string += '/' + min + '/' + max
                break;

            case "date":
                let format = question.firstElementChild.lastElementChild.firstElementChild.value;
                string += '/' + format
                break;
        }

        return string;
    }

    //AJOUTE LA QUESTION AU TABLEAU DINPUT
    function addTabQuestion(type, title, name, required , question) {
        let newInput = document.createElement('input')
        newInput.type = 'hidden'

        newInput.value = 'in_page'+n+'/'        
                        + type
                        + '/' 
                        + required
                        + '/'
                        + title
                        + addTabChoice(type, question)
        newInput.name = name; //On ajoute l'input au tableau d'input qu'on affiche à la fin

        console.log(newInput)
        tabInput.push(newInput)
    }

    function questionToInput(questions){
        for (let index = 0; index < questions.length; index++) {
            let _type = questions[index].id.split('-')[2]
            let _required = questions[index].children[1].firstElementChild.checked
            let _title = questions[index].firstElementChild.firstElementChild.lastElementChild.value
            let _name = questions[index].firstElementChild.firstElementChild.lastElementChild.name
            addTabQuestion(_type, _title, _name, _required , questions[index])
            
        }
    }

    
    function pageToInput(page){
        let addPage = document.createElement('input')
        addPage.type = 'hidden'

        addPage.value = 'page/' +                           //type
                        page.firstChild.lastElementChild.value +   //title
                        '/' + 
                        page.children[1].children.length    //nb_question
        addPage.name = 'page'+n;
        tabInput.push(addPage)
        questionToInput(page.children[1].children)
        n++
    }


    allPage.forEach(page => pageToInput(page))

    //on affiche le nouveau form
    let title = document.createElement('input');
    title.setAttribute('type', 'hidden');
    let idForm = document.getElementById('document-settings-ID').innerHTML
    let expireForm = document.getElementById('document-settings-date').value
    title.setAttribute('value',
        document.getElementById('document-title-input').value +
        '/' +
        idForm +
        '/' +
        expireForm
    );
    title.setAttribute('name', "form-title-ID");

    formTemp.appendChild(title)
    tabInput.forEach(input => formTemp.appendChild(input))
}