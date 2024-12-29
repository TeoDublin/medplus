window.modalHandlers['prenota_seduta_planning_ora'] = {
    btnSalva:function(element){
        let _data = { stato_prenotazione:'Prenotata',table:'sedute_prenotate'};
        const modal = element.closest('.modal');
        modal.querySelectorAll('[name]').forEach(named=>{_data[named.name]=named.value;});
        $.post('post/save.php',_data).done(function(){ 
            reload_modal_component('percorsi','percorsi',{'id_cliente':_data['id_cliente']});
        }).fail(function(){fail()});
    }
}