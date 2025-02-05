window.modalHandlers['prenota_planning_ora'] = {
    btnSalva:function(element){
        const modal = element.closest('.modal');
        const { idPercorso, idSeduta, idCliente, idTerapista,idDate } = element.dataset;
        let _data = { 
            table:'percorsi_terapeutici_sedute_prenotate',
            id_terapista:idTerapista,
            id_seduta:idSeduta,
            id_percorso:idPercorso,
            data:idDate,
            id_cliente:idCliente,
            stato_prenotazione:'Prenotata'
        };
        
        modal.querySelectorAll('[name]').forEach(named=>{_data[named.name]=named.value;});
        $.post('post/save.php',_data).done(function(){ 
            reload_modal_component('percorsi','percorsi',{id_cliente:idCliente,id_percorso:idPercorso,id_seduta:idSeduta});
        }).fail(function(){fail()});
    }
};