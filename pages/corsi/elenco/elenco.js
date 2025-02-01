
function searchClick(){
    window.location.href=window.location.href+"?search="+document.querySelector('.input-search').value;
}
function editClick(element,id){
    if(element.classList.contains('warning')){
        delClick(id);
    }
    else{
        add(id);
    }
}
function delClick(id){
    if(confirm('Sicuro di voler Eliminare?')){
        $.post("post/corsi_delete.php",{id:id}).done(success_and_refresh).fail(fail);
    }
};
function add(id){
    let _data = { table:'corsi', header:'Corsi' };
    if(id){_data["id"]=id;}
    modal_component('modal','corsi_elenco',_data);
}
document.addEventListener('DOMContentLoaded',function(){
    search_table({table:'view_corsi','cols':['categoria','corso','terapista','prezzo_tabellare','scadenza','giorni']});
});