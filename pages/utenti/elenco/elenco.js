
function searchClick(){
    window.location.href=window.location.href+"?search="+document.querySelector('.input-search').value;
}
function editClick(element,id){
    if(element.classList.contains('warning')){
        delClick(id);
    }
    else{
        modal_component('utenti','utenti',{id_utente:id});
    }
}
function delClick(id){
    if(confirm('Sicuro di voler Eliminare?')){
        $.post("post/delete.php",{table:'utenti',id:id}).done(success_and_refresh).fail(fail);
    }
};
function add(id){
    modal_component('utenti','utenti',{id_utente:id});
}
document.addEventListener('DOMContentLoaded',function(){
    search_table({table:'utenti', 'cols':['nome','user']});
});