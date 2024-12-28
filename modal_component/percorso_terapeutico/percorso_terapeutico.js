function btnSalva(modal_id){
    let _data = {table:'percorsi'};
    let div_modal = document.querySelector('#'+modal_id);
    div_modal.querySelectorAll('[name]').forEach(element=>{
        _data[element.name]=element.value;
    });
    $.post('post/save.php',_data).done(function(){
        reload_modal_component('percorsi','percorsi',_data);
    }).fail(function(){fail()});
}