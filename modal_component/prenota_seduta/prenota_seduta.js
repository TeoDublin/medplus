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
function dayClick(element){
    modal_component('prenota-prenota_seduta_planning','prenota_seduta_planning',{});
}
function monthChange(element){
    const modal = element.closest('.modal');
    modal_component('customer-picker_prenota_seduta','prenota_seduta',{month: modal.querySelector('#prenota_month').value });
}