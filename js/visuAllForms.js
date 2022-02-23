
let allFormsDiv = document.getElementById('allFormsDiv');
let viewMode = 'bloc'

function layoutVisuAllForms() {
    if (allFormsDiv.classList.item(0) === "displayBloc") {
        let n = Math.round(window.innerWidth * 2 / 500)
        document.documentElement.style.setProperty('--layoutVisuAllForms', n)
    }
}
window.addEventListener('resize', layoutVisuAllForms)


let btn_grid = document.getElementById('btn-grid-view')
let btn_list = document.getElementById('btn-list-view')

function setView(view) {
    viewMode = view
    if(view === 'list'){
        allFormsDiv.setAttribute('style',
            'flex-wrap: unset;'+
            'flex-direction: column;'
        )
    }
    else{
        allFormsDiv.removeAttribute('style')
    }
    getForms()
}
btn_grid.addEventListener('click', setView.bind(null,'grid'))
btn_list.addEventListener('click', setView.bind(null,'list'))