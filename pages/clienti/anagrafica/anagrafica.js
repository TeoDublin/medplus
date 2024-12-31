

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
        percorso(id);
    }
    else if(element.classList.contains('success2')){
        corsi(id);
    }
    else if(element.classList.contains('success3')){
        percorsoPagamento(id);
    }
    else{
        add(id);
    }
}
function percorso(id){
    modal_component('percorsi','percorsi',{id_cliente:id});
}
function percorsoPagamento(id){
    modal_component('percorsi_pagamenti','percorsi_pagamenti',{id_cliente:id});
}
function add(id){
    let _data = { table:'clienti', header:'Cliente' };
    if(id){_data["id"]=id;}
    modal_component('modal','modal',_data);
}
document.addEventListener('DOMContentLoaded',function(){
    search_table({
        table:'clienti',
        cols:['id','nominativo','telefono','email'],
        actions:{ Trattamenti:'success', Corsi:'success2', Pagamenti:'success3' }
    });
});