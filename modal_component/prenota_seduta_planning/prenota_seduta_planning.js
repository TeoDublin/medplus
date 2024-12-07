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
function sbarraClick(element){
    const planning_motivi_id = element.getAttribute('planning_motivi_id');
    modal_component('planning', 'prenota_seduta_planning_ora', { });
}