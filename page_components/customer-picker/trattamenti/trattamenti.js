function btnPercorsoClick() {
    modal_component('customer-picker_trattamenti','percorso_terapeutico',{'id_cliente':document.querySelector('#id_cliente').value});
}
function aggiungiSeduteClick(element){
    modal_component('customer-picker_sedute','sedute',{'id_cliente':document.querySelector('#id_cliente').value,'id_percorso':element.closest('[name=row_percorso]').querySelector('[name=id_percorso]').value});
}
function aggiungiEnter(element){
    element.closest('[name=row_percorso]').removeAttribute('data-bs-toggle');
}
function aggiungiLeave(element){
    element.closest('[name=row_percorso]').setAttribute('data-bs-toggle','collapse');
}
function prenotaSeduteClick(element,id_seduta,id_cliente){
    modal_component('customer-picker_prenota_seduta','prenota_seduta',{'id_seduta':element.closest('[name=row_percorso]').querySelector('[name=id_seduta]').value,id_seduta:id_seduta,id_cliente:id_cliente});
}
function prenotaEnter(element){
    element.closest('[name=row_percorso]').removeAttribute('data-bs-toggle');
}
function prenotaLeave(element){
    element.closest('[name=row_percorso]').setAttribute('data-bs-toggle','collapse');
}
function editClick(element){
    modal_component('customer-picker_trattamenti','percorso_terapeutico',{'id_cliente':document.querySelector('#id_cliente').value,'id':element.closest('[name=row_percorso]').querySelector('[name=id_percorso]').value});
}
function editEnter(element){
    element.closest('[name=row_percorso]').removeAttribute('data-bs-toggle');
}
function editLeave(element){
    element.closest('[name=row_percorso]').setAttribute('data-bs-toggle','collapse');
}
function deleteClick(element){
    if(confirm('sicuro di voler eliminare ?')){
        $.post('post/delete.php',{id:element.closest('[name=row_percorso]').querySelector('[name=id_percorso]').value,table:'percorsi'}).done(function(){success();parent._tab(document.querySelector('[tab=trattamenti]'));}).fail(function(){fail();});
    }
}
function deleteEnter(element){
    let row_percorso=element.closest('[name=row_percorso]');
    row_percorso.removeAttribute('data-bs-toggle');
    row_percorso.classList.add('warning');
}
function deleteLeave(element){
    let row_percorso=element.closest('[name=row_percorso]');
    row_percorso.setAttribute('data-bs-toggle','collapse');
    row_percorso.classList.remove('warning');
}
function refresh(element){
    modal_component('customer-picker_trattamenti','percorso_terapeutico',{'id_cliente':document.querySelector('#id_cliente').value,'id':element.closest('[name=row_percorso]').querySelector('[name=id_percorso]').value});
}

