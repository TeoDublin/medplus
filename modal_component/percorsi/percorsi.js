function btnPercorsoClick() {
    modal_component('percorso_terapeutico','percorso_terapeutico',{'id_cliente':document.querySelector('#id_cliente').value});
}
function aggiungiSeduteClick(element){
    const modal = element.closest('.modal');
    modal_component('sedute','sedute',{
        'id_cliente':modal.querySelector('#id_cliente').value,
        'id_percorso':element.closest('[name=row_percorso]').querySelector('[name=id_percorso]').value
    });
}
function aggiungiEnter(element){
    element.closest('[name=row_percorso]').removeAttribute('data-bs-toggle');
}
function aggiungiLeave(element){
    element.closest('[name=row_percorso]').setAttribute('data-bs-toggle','collapse');
}
function prenotaSeduteClick(element,id_seduta,id_cliente){
    modal_component('prenota_seduta','prenota_seduta',{
        'id_seduta':element.closest('[name=row_percorso]').querySelector('[name=id_seduta]').value,
        id_seduta:id_seduta,
        id_cliente:id_cliente
    });
}
function prenotaEnter(element){
    element.closest('[name=row_percorso]').removeAttribute('data-bs-toggle');
}
function prenotaLeave(element){
    element.closest('[name=row_percorso]').setAttribute('data-bs-toggle','collapse');
}
function editClick(element){
    const modal = element.closest('.modal');
    modal_component('percorso_terapeutico','percorso_terapeutico',{
        'id_cliente':modal.querySelector('#id_cliente').value,
        'id':element.closest('[name=row_percorso]').querySelector('[name=id_percorso]').value
    });
}
function editEnter(element){
    element.closest('[name=row_percorso]').removeAttribute('data-bs-toggle');
}
function editLeave(element){
    element.closest('[name=row_percorso]').setAttribute('data-bs-toggle','collapse');
}
function deleteClick(element){
    if(confirm('sicuro di voler eliminare ?')){
        $.post('post/delete.php',{
            id:element.closest('[name=row_percorso]').querySelector('[name=id_percorso]').value,
            table:'percorsi'
        }).done(function(){
            const id_cliente = element.closest('.modal').querySelector('#id_cliente').value;
            closeAllModal();
            modal_component('percorsi','percorsi',{'id_cliente':id_cliente});
            success();
        }).fail(function(){fail();});
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
function deleteSedutaPrenotata(element,id){
    $.post('post/delete.php',{table:'sedute_prenotate',id:id}).done(()=>{
        const id_cliente = element.closest('.modal').querySelector('#id_cliente').value;
        closeAllModal();
        modal_component('percorsi','percorsi',{'id_cliente':id_cliente});
        success();
    }).fail(function(){fail()});
}
function enterSedutaPrenotata(element){
    element.closest('div.flex-row').classList.add('bg-danger');
}
function leaveSedutaPrenotata(element){
    element.closest('div.flex-row').classList.remove('bg-danger');
}
function changeStatoPrenotazione(element,id){
    $.post('post/save.php',{
        table:'sedute_prenotate',
        stato_prenotazione:element.value,
        id:id
    }).done(()=>{
        modal_component('percorsi','percorsi',{
            'id_cliente':element.closest('.modal').querySelector('#id_cliente').value
        });
        success();
    }).fail(()=>fail());
}