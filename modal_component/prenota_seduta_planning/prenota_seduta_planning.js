window.modalHandlers['prenota_seduta_planning'] = {
    prenotaHoverRow:function(element){
        document.querySelector('#prenota-prenota_table').classList.remove('table-separate');
        document.querySelectorAll('.sbarra_hovered').forEach(cell=>{cell.classList.remove('sbarra_hovered');})
        document.querySelectorAll('.hovered').forEach(cell=>{cell.classList.remove('hovered');})
        if(element.classList.contains('sbarra')){
            const sedute_prenotate_id = element.getAttribute('sedute_prenotate_id');
            document.querySelectorAll(`[sedute_prenotate_id="${sedute_prenotate_id}"]`).forEach(cell => {
                cell.classList.add('sbarra_hovered');
                cell.querySelectorAll('input').forEach(cellInput=>{
                    cellInput.readOnly=true;
                    cellInput.disabled=true;
                });
            });
            document.querySelector('#prenota-prenota_table').classList.add('table-separate');
        }
        else{
            const row = element.getAttribute('row');
            document.querySelectorAll(`[row="${row}"]`).forEach(cell => {
                cell.classList.add('hovered');
            });
        }
    },
    prenotaSedutaClick:function(element,id_cliente){
        if(!element.classList.contains('sbarra')){
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