window.modalHandlers['prenota_planning'] = {
    bind_modal_functions:function(){
        window.modalHandlers['planning'].rowClick=function(element,origin){
            const planning_motivi_id = element.getAttribute('planning_motivi_id');
            const modal = element.closest('.modal');
            switch (origin) {
                case 'empty':
                    modal_component('sbarra', 'prenota_planning_ora', { 
                        'id_terapista': modal.querySelector('#terapista').value,
                        'data':modal.querySelector('#data').value, 
                        'planning_motivi_id':planning_motivi_id,
                        'row': element.getAttribute('row'),
                        'id_seduta': modal.querySelector('#id_seduta').value,
                        'id_cliente': modal.querySelector('#id_cliente').value,
                        'id_percorso': modal.querySelector('#id_percorso').value,
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
                    id:'prenota_planning', 
                    component:'prenota_planning',
                    data:{
                        id_seduta:modal.querySelector('#id_seduta').value,
                        id_cliente:modal.querySelector('#id_cliente').value,
                        id_percorso:modal.querySelector('#id_percorso').value,
                        id_terapista:modal.querySelector('#terapista').value,
                        data:modal.querySelector('#data').value,
                        rows:modal.querySelector('#rows').value,
                    }
                },
            ]);
        };
    }
}
window.modalHandlers['prenota_planning'].bind_modal_functions();