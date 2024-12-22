function aggiungiFattureClick(element,id_cliente){
    modal_component('fattura','fattura',{
        id_percorso:element.closest('.accordion-button').querySelector('#id_percorso').value,
        id_cliente:id_cliente
    });
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
        closeAllModal();
        modal_component('percorsi','percorsi_pagamenti',{id_cliente:id_cliente});
        success();
    }).fail(()=>{fail()});
}