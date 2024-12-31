window.modalHandlers['prenota_seduta_planning_ora'] = {
    btnSalva:function(element,id_percorso){
        let _data = { stato_prenotazione:'Prenotata',table:'percorsi_terapeutici_sedute_prenotate',id_percorso:id_percorso};
        const modal = element.closest('.modal');
        modal.querySelectorAll('[name]').forEach(named=>{_data[named.name]=named.value;});
        if(_data['id_seduta']=='false'){
            $.post('post/prenota_percorso_mensile.php',_data).done(function(){ 
                reload_modal_component('percorsi','percorsi',{id_cliente:_data['id_cliente'],id_percorso:id_percorso,id_seduta:_data['id_seduta']});
            }).fail(function(){fail()});
        }
        else{
            $.post('post/save.php',_data).done(function(){ 
                reload_modal_component('percorsi','percorsi',{id_cliente:_data['id_cliente'],id_percorso:id_percorso,id_seduta:_data['id_seduta']});
            }).fail(function(){fail()});
        }

    }
}