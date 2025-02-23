function bind_modal_functions(){
    window.modalHandlers['planning'].rowClick=function(element,origin,id_terapista){
        const planning_motivi_id = element.getAttribute('planning_motivi_id');
        switch (origin) {
            case 'sbarra':
            case 'empty':
                modal_component('sbarra', 'sbarra', { 'id_terapista': id_terapista,'data':document.querySelector('#data').value, 'planning_motivi_id':planning_motivi_id,'row': element.getAttribute('row')});
                break;
            case 'corso':
                modal_component('sbarra', 'sposta_corso', { 
                    'id_terapista': id_terapista,
                    'data':document.querySelector('#data').value, 
                    'id_corso':planning_motivi_id,
                    'row': element.getAttribute('row')
                });
                break;
            case 'seduta':
                modal_component('sbarra', 'sposta_seduta', { 
                    'id_terapista': id_terapista,
                    'data':document.querySelector('#data').value, 
                    'id_seduta':planning_motivi_id,
                    'row': element.getAttribute('row')
                });
                break;
            case 'colloquio':
                modal_component('sbarra', 'sposta_colloquio', { 
                    'id_terapista': id_terapista,
                    'data':document.querySelector('#data').value, 
                    'id_seduta':planning_motivi_id,
                    'row': element.getAttribute('row')
                });
                break;
            default:
                console.log(origin);
                break;
        }
    };
    window.modalHandlers['planning'].change=function(element){
        refresh({
            id_terapista:document.querySelector('#terapista').value,
            data:document.querySelector('#data').value
        });
    };
}
bind_modal_functions();