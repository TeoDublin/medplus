function aggiungiFattureClick(element,id_cliente){
    if(!element.querySelector('.btn').classList.contains('disabled')){
        modal_component('fattura','fattura',{
            id_percorso:element.closest('.accordion-button').querySelector('#id_percorso').value,
            id_cliente:id_cliente
        });
    }
}
function aggiungiEnter(element){
    element.closest('[name=row_percorso]').removeAttribute('data-bs-toggle');
}
function aggiungiLeave(element){
    element.closest('[name=row_percorso]').setAttribute('data-bs-toggle','collapse');
}
function changeStato(stato,id,id_cliente){
    $.post('post/save.php',{
        table:'percorsi_pagamenti_fatture',
        stato:stato,
        id:id
    }).done(()=>{
        reload_modal_component('percorsi','percorsi_pagamenti',{id_cliente:id_cliente});
    }).fail(()=>{fail()});
}
function deleteFattura(element,id){
    if(confirm('sicuro di voler eliminare ?')){
        $.post('post/delete.php',{table:'fatture',id:id}).done(()=>{
            const id_cliente = element.closest('.modal').querySelector('#id_cliente').value;
            reload_modal_component('percorsi','percorsi_pagamenti',{'id_cliente':id_cliente});
        }).fail(function(){fail()});
    }
}
function enterFattura(element){
    element.closest('div.flex-row').classList.add('bg-danger');
}
function leaveFattura(element){
    element.closest('div.flex-row').classList.remove('bg-danger');
}