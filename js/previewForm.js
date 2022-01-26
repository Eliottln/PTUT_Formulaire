const PREVIEW = document.getElementById('preview-link')

PREVIEW.addEventListener('click',buildPreview)

function buildPreview(){
    let allPage = document.querySelectorAll('.page')
    let page = 0

    let previewContent = '<div><h2>'+document.getElementById('document-title-input').value+'</h2></div>'

    function displayQuestion(i){
        let allQuestion = allPage[i].children[1].children

        for (let j = 0; j<allQuestion.length; j++){
            let id = allQuestion[j].id
            let type = id.split('-')[2]

            let questionTitle = document.querySelector('#'+id+' .question').value
        }
    }

    allPage.forEach(p => {
        previewContent+='<h4>'+p.firstElementChild.lastElementChild.value+'</h4>'
    })

    document.getElementById('preview-mode').innerHTML = previewContent
}