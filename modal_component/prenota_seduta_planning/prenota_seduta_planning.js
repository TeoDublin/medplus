window.modalHandlers['prenota_seduta_planning'] = {
    prenotaSedutaClick:function(element,id_cliente){
        if(!element.classList.contains('sbarra')&&!element.classList.contains('seduta')){
            const modal = element.closest('.modal');
            let _data = { 
                'row': element.getAttribute('row'),
                'sedute_prenotate_id':element.getAttribute('sedute_prenotate_id')
            };
            modal.querySelectorAll('[name]').forEach(named=>{_data[named.name]=named.value;});
            _data['id_cliente']=id_cliente;
            modal_component('planning-prenota_seduta_planning_ora', 'prenota_seduta_planning_ora', _data);
        }
    }
}