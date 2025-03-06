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
            data:document.querySelector('#data').value
        });
    };
    window.modalHandlers['planning'].removeDay=function(element){
        const dataInput = document.querySelector('#data');
        const currentDate = new Date(dataInput.value);
        currentDate.setDate(currentDate.getDate() + -1);
        dataInput.value = currentDate.toISOString().split('T')[0];
        window.modalHandlers['planning'].change(element);
    };
    window.modalHandlers['planning'].addDay=function(element){
        const dataInput = document.querySelector('#data');
        const currentDate = new Date(dataInput.value);
        currentDate.setDate(currentDate.getDate() + 1);
        dataInput.value = currentDate.toISOString().split('T')[0];
        window.modalHandlers['planning'].change(element);
    };
}
bind_modal_functions();