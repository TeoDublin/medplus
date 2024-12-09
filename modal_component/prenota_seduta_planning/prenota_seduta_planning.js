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
function btnSalva(modal_id){
    let _data = {table:'sedute_prenotate'};
    let div_modal = document.querySelector('#'+modal_id);
    div_modal.querySelectorAll('[name]').forEach(element=>{
        _data[element.name]=element.value;
    });
    $.post('post/save.php',_data).done(function(){
        div_modal.modalInstance.hide();
        parent._tab(document.querySelector('[tab=trattamenti]'));
        success();
    }).fail(function(){fail()});
}
function prenotaSbarraClick(element){
    if(!element.classList.contains('sbarra')){
        modal_component('planning-prenota_seduta_planning_ora', 'prenota_seduta_planning_ora', { 'row':element.getAttribute('row')});
    }
}
