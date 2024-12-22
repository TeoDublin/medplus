function btnSalva(element){
    const _data = { stato_prenotazione:'Prenotata',table:'sedute_prenotate'};
    const modal = element.closest('.modal');
    modal.querySelectorAll('[name]').forEach(named=>{_data[named.getAttribute('name')]=named.value;});
    $.post('post/save.php',_data).done(function(){ 
        const id_cliente = modal.querySelector('[name=id_cliente]').value;
        closeAllModal();
        modal_component('percorsi','percorsi',{'id_cliente':id_cliente});
        success();
    }).fail(function(){fail()});
}