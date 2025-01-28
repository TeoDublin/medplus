
function searchClick(){
    window.location.href=window.location.href+"?search="+document.querySelector('.input-search').value;
}
function editClick(element,id){
    if(element.classList.contains('warning')){
        delClick(id);
    }
}
function delClick(id){
    if(confirm('Sicuro di voler Eliminare?')){
        $.post("post/delete.php",{table:'corsi_classi',id:id}).done(success_and_refresh).fail(fail);
    }
};

document.addEventListener('DOMContentLoaded',function(){
    search_table({table:'view_classi','cols':['corso','terapista','nominativo','scadenza','prezzo_tabellare','prezzo']});
});