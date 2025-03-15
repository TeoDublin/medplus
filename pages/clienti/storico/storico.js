

function delClick(id){
    if(confirm('Sicuro di voler Eliminare?')){
        $.post("post/delete.php",{table:'clienti',id:id}).done(success_and_refresh).fail(fail);
    }
};
function searchClick(){
    window.location.href=window.location.href+"?search="+document.querySelector('.input-search').value;
}
function editClick(element,id){
    if(element.classList.contains('warning')){
        delClick(id);
    }
    else if(element.classList.contains('success')){
        trattamenti(id);
    }
    else if(element.classList.contains('success4')){
        percorsoFatture(id);
    }
}
function trattamenti(id){
    modal_component('percorsi','percorsi',{id_cliente:id, storico:true});
}
function percorsoFatture(id){
    modal_component('percorsi_fatture','percorsi_fatture',{id_cliente:id});
}
document.addEventListener('DOMContentLoaded',function(){
    search_table({
        table:'clienti',
        orderby:'nominativo ASC',
        cols:['id','nominativo','cellulare','email'],
        actions:{ Trattamenti:'success', Pagamenti:'success4' }
    });
});