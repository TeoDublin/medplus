window.modalHandlers['prenota_colloquio'] = {
    bind_modal_functions:function(){
        window.modalHandlers['planning'].rowClick=function(element,origin,id_terapista){
            const planning_motivi_id = element.getAttribute('planning_motivi_id');
            const modal = element.closest('.modal');
            switch (origin) {
                case 'empty':
                    modal_component('sbarra', 'prenota_colloquio_ora', { 
                        'id_terapista': id_terapista,
                        'data':modal.querySelector('#data').value, 
                        'planning_motivi_id':planning_motivi_id,
                        'row': element.getAttribute('row'),
                        'id_cliente': modal.querySelector('#id_cliente').value,
                    });
                    break;
            
                default:
                    console.log(origin);
                    break;
            }
        };
        window.modalHandlers['planning'].change=function(element){
            let modal = element.closest('.modal');
            reload_modal_component_tree([
                {
                    id:'percorsi', 
                    component:'percorsi',
                    data:{
                        id_cliente:modal.querySelector('#id_cliente').value,
                    }
                },
                {
                    id:'prenota_colloquio', 
                    component:'prenota_colloquio',
                    data:{
                        id_cliente:modal.querySelector('#id_cliente').value,
                        data:modal.querySelector('#data').value
                    }
                },
            ]);
        };
    }
}
window.modalHandlers['prenota_colloquio'].bind_modal_functions();