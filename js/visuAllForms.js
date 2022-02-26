
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
    if (view === 'list') {
        allFormsDiv.setAttribute('style',
            'flex-wrap: unset;' +
            'flex-direction: column;'
        )
    }
    else {
        allFormsDiv.removeAttribute('style')
    }
    getForms()
}
btn_grid.addEventListener('click', setView.bind(null, 'grid'))
btn_list.addEventListener('click', setView.bind(null, 'list'))

function getWaitingAnimation() {
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

let btn_filter = document.getElementById('btn-filter')

let filter = document.getElementById('filter-panel');
let sortNFilter = new Sort();

function toggleFilter() {
    if (!filter.getAttribute('style')) {
        filter.setAttribute('style', 'height:350px;')
    }
    else {
        filter.removeAttribute('style')
    }
}

btn_filter.addEventListener('click', toggleFilter)

let sortSelector = document.getElementById('sort_select');
sortSelector.addEventListener('change', function () {
    switch (sortSelector.value) {
        case 's1':
            sortNFilter.setSort(Sort.SORT_BY_TITLE)
            break;

        case 's2':
            sortNFilter.setSort(Sort.SORT_BY_AUTHOR)
            break;

        case 's3':
            sortNFilter.setSort(Sort.SORT_BY_PROGRESS)
            break;

        case 's4':
        default:
            sortNFilter.setSort(Sort.SORT_BY_EXPIRE)
            break;
    }
})

let btn_asc = document.getElementById('btn-asc');
btn_asc.addEventListener('click', switchASC_DESC.bind(btn_asc))
let btn_desc = document.getElementById('btn-desc');
btn_desc.addEventListener('click', switchASC_DESC.bind(btn_desc))
switchASC_DESC()

function switchASC_DESC() {
    if (this === btn_asc) {
        sortNFilter.setASC()
        this.classList.add('btn-sortSelect')
        btn_desc.classList.remove('btn-sortSelect')
    }
    else {
        sortNFilter.setDESC()
        btn_desc.classList.add('btn-sortSelect')
        btn_asc.classList.remove('btn-sortSelect')
    }
}

let btn_addFilter = document.getElementById('btn-addFilter');
let listFilter = document.getElementById('filter_selected');
let filterArray = []

let divListFilter = document.getElementById('div-filters-list');

function addFilter() {
    let textSelect = listFilter.options[listFilter.selectedIndex].text

    if (textSelect != '-----' && !filterArray.includes(listFilter.value)) {
        let div = document.createElement('div');
        div.id = listFilter.value
        div.classList.add('filterBloc')
        switch (listFilter.value) {
            case 'f1':
                filterArray.push('f1')
                div.innerHTML = '<button>' +
                    '<img src="/img/clear_white_24dp.svg" alt="clear">' +
                    '</button>' +
                    '<div>' +
                    '<p>' + textSelect + '</p>' +
                    '<input type="text">' +
                    '</div>';

                break;
            case 'f2':
                filterArray.push('f2')
                div.innerHTML = '<button>' +
                    '<img src="/img/clear_white_24dp.svg" alt="clear">' +
                    '</button>' +
                    '<div>' +
                    '<p>' + textSelect + '</p>' +
                    '<input type="text">' +
                    '</div>';

                break;
            case 'f3':
                filterArray.push('f3')
                div.innerHTML = '<button>' +
                    '<img src="/img/clear_white_24dp.svg" alt="clear">' +
                    '</button>' +
                    '<div>' +
                    '<p>' + textSelect + '</p>' +
                    '<select>' +
                    '<option value="full">Complet</option>' +
                    '<option value="in_progress">En cours</option>' +
                    '<option value="no_response">Non répondu</option>' +
                    '</select>' +
                    '</div>';

                break;
            case 'f4':
                filterArray.push('f4')
                div.innerHTML = '<button>' +
                    '<img src="/img/clear_white_24dp.svg" alt="clear">' +
                    '</button>' +
                    '<div>' +
                    '<p>' + textSelect + '</p>' +
                    '</div>';

                break;
            case 'f5':
                filterArray.push('f5')
                div.innerHTML = '<button>' +
                    '<img src="/img/clear_white_24dp.svg" alt="clear">' +
                    '</button>' +
                    '<div>' +
                    '<p>' + textSelect + '</p>' +
                    '</div>';

                break;

            case 'f0':
            default:
                return null
        }
        div.firstChild.addEventListener('click', function(){
            filterArray.splice(
                filterArray.findIndex(
                    (element) => element = div.id
                ),1
                )
            div.remove()
        })

        divListFilter.appendChild(div)
    }

}

btn_addFilter.addEventListener('click', addFilter)

function setfilters() {
    if (divListFilter.children) {
        sortNFilter.clearFilterArray()
        for (let index = 0; index < divListFilter.children.length; index++) {
            
            switch (divListFilter.children[index].id) {
                case 'f1':
                    sortNFilter.addFilter(Sort.FILTER_TITLE, divListFilter.children[index].lastChild.lastChild.value)
                    break;
                case 'f2':
                    sortNFilter.addFilter(Sort.FILTER_AUTHOR, divListFilter.children[index].lastChild.lastChild.value)
                    break;
                case 'f3':
                    sortNFilter.addFilter(Sort.FILTER_PROGRESS, divListFilter.children[index].lastChild.lastChild.value)
                    break;
                case 'f4':
                    sortNFilter.addFilter(Sort.getFILTER_STATUS(), Sort.STATUS.public)
                    break;
                case 'f5':
                    sortNFilter.addFilter(Sort.getFILTER_STATUS(), Sort.STATUS.private)
                    break;
                default:
                    // nothing
                    break;
            }
        }
    }
}