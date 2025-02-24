window.modalHandlers['prenota_colloquio_ora'] = {
    btnSalva:function(element){
        const modal = element.closest('.modal');
        const { idCliente, idTerapista,idDate } = element.dataset;
        let _data = { 
            table:'colloquio_planning',
            id_terapista:idTerapista,
            data:idDate,
            id_cliente:idCliente,
            stato_prenotazione:'Prenotata'
        };
        
        modal.querySelectorAll('[name]').forEach(named=>{_data[named.name]=named.value;});
        $.post('post/save.php',_data).done(function(){ 
            reload_modal_component('percorsi','percorsi',{id_cliente:idCliente});
        }).fail(function(){fail()});
    }
};