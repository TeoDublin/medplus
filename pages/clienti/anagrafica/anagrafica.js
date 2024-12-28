

function delClick(id){
    if(confirm('Sicuro di voler Eliminare?')){
        $.post("post/delete.php",{id:id}).done(success_and_refresh).fail(fail);
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
        addPercorso(id);
    }
    else if(element.classList.contains('success2')){
        addPercorsoPagamento(id);
    }
    else{
        modal(id);
    }
}
function addPercorso(id){
    modal_component('percorsi','percorsi',{id_cliente:id});
}
function addPercorsoPagamento(id){
    modal_component('percorsi','percorsi_pagamenti',{id_cliente:id});
}
function addCliente(){
    modal_component('cliente','modal',{table:'clienti',header:'Cliente',cols:3});
}