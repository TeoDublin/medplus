function btnSalva(element){
    const _data = { stato_prenotazione:'Prenotata',table:'sedute_prenotate'};
    const modal = element.closest('.modal');
    modal.querySelectorAll('[name]').forEach(named=>{_data[named.getAttribute('name')]=named.value;});
    $.post('post/save.php',_data).done(function(){ 
        closeAllModal();
        page_component('planning', 'customer-picker', {
            tab:'trattamenti',
            id_terapista:modal.querySelector('[name=id_terapista]').value,
            data:modal.querySelector('[name=data]').value,
            id_cliente:modal.querySelector('[name=id_cliente]').value
        });
    }).fail(function(){fail()});
}