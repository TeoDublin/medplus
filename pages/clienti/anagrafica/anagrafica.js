

function delClick(element){
    if(confirm('Sicuro di voler Eliminare?')){
        $.post("post/delete.php?skip_cookie=true&table=clienti&id=" + element.closest('tr').getAttribute('rowId')).done(success_and_refresh).fail(fail);
    }
};
function searchClick(){
    window.location.href=window.location.href+"?search="+document.querySelector('.input-search').value;
}
function editClick(element){
    if(!element.classList.contains('warning')&&!element.classList.contains('success')){
        modal(element.getAttribute('rowId'));
    }
}
function addPercorso(element){
    modal_component('percorsi','percorsi',{id_cliente:element.closest('tr').getAttribute('rowid')});
}
function addPercorsoPagamento(element){
    modal_component('percorsi','percorsi_pagamenti',{id_cliente:element.closest('tr').getAttribute('rowid')});
}
function modal(id){
    let _data={ 'name':'clienti','skip_cookie':true,'id_cliente':id };
    $.post('component.php', _data, function(data) {
        document.querySelector('#modal-body').innerHTML = data;
        const modalElement = document.getElementById('modal');
        const modal = new bootstrap.Modal(modalElement);
        modalElement.querySelector('.modal-title').textContent = 'Cliente';
        modalElement.querySelector('.modal-dialog').classList.add('modal-xl');
        const addButton = modalElement.querySelector('.btn-add');
        addButton.replaceWith(addButton.cloneNode(true));
        let _data = {table:'clienti',skip_cookie:true};
        modalElement.querySelector('.btn-add').addEventListener('click', () => {
            modalElement.querySelectorAll('[name]').forEach((modalInput)=>{ _data[modalInput.name] = modalInput.value; });
            modal.hide();
            $.post('post/save.php',_data).done(success_and_refresh).fail(fail);
        });
        append_scripts(modalElement);
        modal.show();
    })
    .catch(error => { console.error('Error fetching customer picker:', error);});
}