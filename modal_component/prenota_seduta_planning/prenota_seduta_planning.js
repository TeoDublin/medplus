function prenotaHoverRow(element){
    document.querySelector('#prenota-prenota_table').classList.remove('table-separate');
    document.querySelectorAll('.sbarra_hovered').forEach(cell=>{cell.classList.remove('sbarra_hovered');})
    document.querySelectorAll('.hovered').forEach(cell=>{cell.classList.remove('hovered');})
    if(element.classList.contains('sbarra')){
        const prenota_motivi_id = element.getAttribute('prenota_motivi_id');
        document.querySelectorAll(`[prenota_motivi_id="${prenota_motivi_id}"]`).forEach(cell => {
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
}
function prenotaSedutaClick(element){
    if(!element.classList.contains('sbarra')){
        const modal = element.closest('.modal');
        let _data = { 
            'row': element.getAttribute('row')
        };
        modal.querySelectorAll('[name]').forEach(named=>{_data[named.getAttribute('name')]=named.value;});
        modal_component('planning-prenota_seduta_planning_ora', 'prenota_seduta_planning_ora', _data);
    }
}
