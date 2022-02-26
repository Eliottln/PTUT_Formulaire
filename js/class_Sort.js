class Sort {

    static SORT_BY_TITLE = 's_title';
    static SORT_BY_AUTHOR = 's_author';
    static SORT_BY_PROGRESS = 's_progress';
    static SORT_BY_EXPIRE = 's_expire';     /* default */

    static FILTER_TITLE = {filter:'f_title',param:null};
    static FILTER_AUTHOR = {filter:'f_author',param:null};
    static FILTER_PROGRESS = {filter:'f_progress',param:null};

    static STATUS = {public:'public',private:'private'};

    constructor(){
        this.sort = Sort.SORT_BY_EXPIRE;
        this.asc_desc = 'DESC';
        this.filterArray = [];
    }

    setSort(sort){
        this.sort = sort;
    }

    setASC(){
        this.asc_desc = 'ASC';
    }

    setDESC(){
        this.asc_desc = 'DESC';
    }
    
    switchASC_DESC(){
        if(this.asc_desc === 'ASC'){
            this.asc_desc = 'DESC';
        }
        else{
            this.asc_desc = 'ASC';
        }
        return this.asc_desc;
    }

    clearFilterArray(){
        this.filterArray = [];
    }

    /**
     * use static filter integrate in this class as filter
     * @param {object} filter 
     * @param {string} param for Sort.FILTER_STATUS you can use Sort.STATUS.public or Sort.STATUS.private
     */
    addFilter(filter,param){
        filter.param = param;
        this.filterArray.push(filter);
        console.log(this.filterArray)
    }

    static getFILTER_STATUS(){
        return {filter:'f_status',param:null}
    }

    toString(){
        
        console.log('sort='+this.sort+'&asc_desc='+this.asc_desc+'&filter='+JSON.stringify(this.filterArray))
        return 'sort='+this.sort+'&asc_desc='+this.asc_desc+'&filter='+JSON.stringify(this.filterArray);
    }
}