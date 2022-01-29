const PREVIEW = document.getElementById('preview-link')

PREVIEW.addEventListener('click',buildPreview)

let page = 0
let formContent = document.querySelector('#form-content')

function buildPreview(){

    let previewContent = '<div><h2>' + document.getElementById('document-title-input').value + '</h2></div>'

    if (formContent.children[page] !== undefined) {

        let currentPage = formContent.children[page]

        if (currentPage.children[1].childElementCount>0) {

            previewContent += '<h4>' + currentPage.firstElementChild.lastElementChild.value + '</h4>'

            displayQuestion()
            function displayQuestion() {
                let allQuestion = currentPage.children[1].children

                for (let j = 0; j < allQuestion.length; j++) {
                    let id = allQuestion[j].id
                    let type = id.split('-')[2]

                    let questionTitle = document.querySelector('#' + id + ' .question').value

                    switch (type){
                        case 'checkbox':
                        case 'radio':
                            let choiceCount = document.querySelectorAll('#' + id + ' .choice')
                            let tmpString = ''
                            choiceCount.forEach(c => {
                                tmpString +=
                                    '<div class="'+type+'VisuForm">' +
                                    '<input type="'+type+'">' +
                                    '<label>'+c.children[2].value+'</label>' +
                                    '</div>'
                            })

                            previewContent +=
                                '<div>' +
                                    '<label class="questionTitle">'+questionTitle+'</label>'+
                                    '<div class="'+type+'-group">'+tmpString+'</div>'+
                                '</div>'
                            break
                    }

                }
            }



        }

        document.getElementById('preview-mode').innerHTML = previewContent
        page++

    }
}