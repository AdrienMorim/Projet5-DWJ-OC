function onClickBtnCheck(event){
    event.preventDefault();

    const url = this.href;
    const div = this.querySelector('div');
    const icone = this.querySelector('i');

    //axios.get(url).then(function(response) {
    $.get(url, function(){
        if (icone.classList.contains('fa-check-circle') && div.classList.contains('checked-categories')){
            icone.classList.replace('fa-check-circle','fa-plus-circle');
            div.classList.replace('checked-categories', 'add-categories');
        } 
        else{
            icone.classList.replace('fa-plus-circle','fa-check-circle');
            div.classList.replace('add-categories', 'checked-categories');
        }
    })
}

document.querySelectorAll('a.link-js').forEach(function(link) {
    link.addEventListener('click', onClickBtnCheck);
})