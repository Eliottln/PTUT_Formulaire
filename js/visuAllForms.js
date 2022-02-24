
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

function getWaitingAnimation(){
    let div = document.createElement('div');
    div.classList.add('WaitingAnimation');
    
    // Circles
    let c1 = document.createElement('div');
    c1.classList.add('circle');
    let c2 = document.createElement('div');
    c2.classList.add('circle');
    let c3 = document.createElement('div');
    c3.classList.add('circle');
    div.appendChild(c1);
    div.appendChild(c2);
    div.appendChild(c3);

    // Shadow
    let s1 = document.createElement('div');
    s1.classList.add('shadow');
    let s2 = document.createElement('div');
    s2.classList.add('shadow');
    let s3 = document.createElement('div');
    s3.classList.add('shadow');
    div.appendChild(s1);
    div.appendChild(s2);
    div.appendChild(s3);
    return div
}

//let allFormsDiv = document.getElementById('filter-panel');