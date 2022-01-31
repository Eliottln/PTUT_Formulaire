const PREVIEW = document.getElementById('preview-link')

PREVIEW.addEventListener('click',buildPreview)

let page = 0
let formContent = document.getElementById('form-content')
let previewMod = document.getElementById('preview-mode')

function buildPreview() {

    if (formContent.children[page] !== undefined) {

        let currentPage = formContent.children[page]

        if (currentPage.children[1].childElementCount > 0) {

            previewMod.style.display = 'flex'
            previewMod.style.flexDirection = 'column'

            let previewContent =
                '<button id="quit-preview" class="buttonBack" type="button">« Quitter l\'aperçu</button>' +
                '<div id="page"><div>' +
                '<h2>' + document.getElementById('document-title-input').value + '</h2>' +
                '</div>'+
                '<h4>' + currentPage.firstElementChild.lastElementChild.value + '</h4><div>'

            let allQuestion = currentPage.children[1].children

            for (let j = 0; j < allQuestion.length; j++) {
                let id = allQuestion[j].id
                let type = id.split('-')[2]

                let questionTitle = document.querySelector('#' + id + ' .question').value

                if (questionTitle === ''){
                    break
                }
                switch (type) {
                    case 'checkbox':
                    case 'radio':
                        let tmpString = ''
                        let choiceCount = document.querySelectorAll('#' + id + ' .choice')
                        choiceCount.forEach(c => {
                            tmpString +=
                                '<div class="' + type + 'VisuForm">' +
                                '<input type="' + type + '">' +
                                '<label>' + c.children[2].value + '</label>' +
                                '</div>'
                        })
                        previewContent +=
                            '<div>' +
                            '<label class="questionTitle">' + questionTitle + '</label>' +
                            '<div class="' + type + '-group">' + tmpString + '</div>' +
                            '</div>'
                        break

                    case 'range':
                        let rangeChoice = document.querySelectorAll('#' + id + ' .choice-input')
                        previewContent +=
                            '<div>' +
                            '<label class="questionTitle">' + questionTitle + '</label>' +
                            '<div class="range-group">' +
                            '<h4>' + rangeChoice[0].value + '</h4>' +
                            '<input type="range">' +
                            '<h4>' + rangeChoice[1].value + '</h4>' +
                            '</div>' +
                            '</div>'
                        break

                    case 'number':
                        let numberChoice = document.querySelectorAll('#' + id + ' .choice-input')
                        previewContent +=
                            '<div>' +
                            '<label class="questionTitle">' + questionTitle + '</label>' +
                            '<input type="number" min="' + numberChoice[0].value + '" max="' + numberChoice[1].value + '">' +
                            '</div>'
                        break

                    case 'textarea':
                        previewContent +=
                            '<div>' +
                            '<label class="questionTitle">' + questionTitle + '</label>' +
                            '<textarea placeholder="Écrire ici..."></textarea>' +
                            '</div>'
                        break

                    case 'date':
                        let date = document.querySelector('#' + id + ' select')
                        if (date.value === 'duration') {
                            previewContent +=
                                '<div>' +
                                '<label class="questionTitle">' + questionTitle + '</label>' +
                                '<div class="date-group">' +
                                '<label>Du :<input type="datetime-local"></label>' +
                                '<label>Au :<input type="datetime-local"></label>' +
                                '</div>' +
                                '</div>'
                        } else {
                            previewContent +=
                                '<div>' +
                                '<label class="questionTitle">' + questionTitle + '</label>' +
                                '<input type="' + date.value + '">' +
                                '</div>'
                        }
                        break

                    case 'select':
                        let select = document.querySelector('#' + id + ' select')
                        previewContent +=
                            '<div>' +
                            '<label class="questionTitle">' + questionTitle + '</label>' +
                            '<select>' +
                            select.innerHTML +
                            '</select>' +
                            '</div>'
                        break

                    default:
                        previewContent +=
                            '<div>' +
                            '<label class="questionTitle">' + questionTitle + '</label>' +
                            '<input type="' + type + '" placeholder="Entrer ' + type + '...">' +
                            '</div>'
                        break
                }

            }

            if (formContent.children[page+1] === undefined){
                previewContent += '</div><button id="next-preview" class="buttonVisuForm" type="button"><span>Terminer</span></button></div>'
            }
            else{
                previewContent += '</div><button id="next-preview" class="buttonVisuForm" type="button"><span>Suivant »</span></button></div>'
            }

            previewMod.innerHTML = previewContent
            document.getElementById('quit-preview').addEventListener('click', function () {
                previewMod.innerHTML = ''
                previewMod.style.display = 'none'
                page = 0
            })
            document.getElementById('next-preview').addEventListener('click', function (){
                page++
                buildPreview()
            })

            if (document.getElementById('page').children[2].innerHTML === ''){
                page++
                buildPreview()
            }

        }
        else{
            page++
            buildPreview()
        }
    }
    else {
        previewMod.innerHTML = ''
        previewMod.style.display = 'none'
        page = 0
    }
}