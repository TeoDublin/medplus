function btnSalva(element){
    const _data = { stato_prenotazione:'Prenotata',table:'sedute_prenotate'};
    const modal = element.closest('.modal');
    modal.querySelectorAll('[name]').forEach(named=>{_data[named.getAttribute('name')]=named.value;});
    $.post('post/save.php',_data).done(function(){
        modal_component('prenota-prenota_seduta_planning','prenota_seduta_planning',_data)
    }).fail(function(){fail()});
}