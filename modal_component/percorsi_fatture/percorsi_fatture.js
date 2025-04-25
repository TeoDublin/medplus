window.modalHandlers['percorsi_fatture']={
    deletePersistent:'fattura',
    enterRow:function(element){
        element.closest('.fattura_row').classList.add('success');
    },
    leaveRow:function(element){
        element.closest('.fattura_row').classList.remove('success');
    },
    clickRow: (element) => {
        window.open(element.closest('.fattura_row').querySelector('#link').href, '_blank');
    },
    enterDelete:function(element){
        element.closest('.fattura_row').classList.add('warning');
    },
    leaveDelete:function(element){
        element.closest('.fattura_row').classList.remove('warning');
    },
    clickDelete:function(id,id_cliente,table){
        if(confirm('sicuro di voler eliminare ?')){
            $.post('post/delete_percorsi_fatture.php',{table:table,id:id}).done(()=>{
                reload_modal_component('percorsi_fatture','percorsi_fatture',{id_cliente:id_cliente});
            }).fail(()=>{fail()});
        }
    },
    clickEdit:function(e){
        modal_component('fattura','fattura',JSON.parse(e.dataset.request));
    },
    enterStato:function(element){
    },
    leaveStato:function(element){
    },
    enterEdit:function(element){
        element.closest('div.fattura_row').classList.add('bg-success');
    },
    leaveEdit:function(element){
        element.closest('div.fattura_row').classList.remove('bg-success');
    },
    changeStato:function(stato,id){
        $.post('post/fattura_cambia_stato.php',{stato:stato,id:id}).done(()=>{success()}).fail(()=>{fail()});
    },
    changeFatturatoDa:function(fatturato_da,id){
        $.post('post/fattura_cambia_fatturato_da.php',{fatturato_da:fatturato_da,id:id}).done(()=>{success()}).fail(()=>{fail()});
    },
}
window.modalHandlers['fattura'] = Object.assign(
    window.modalHandlers['fattura'] || {},
    {
    persistent:true,
    generatePDF:function(element,oggetti) {
        oggetti.doing_edit=true;
        $.post('post/fattura.php',_data(element,oggetti)).done(response=>{
            window.open(response,'_blank');
            reload_modal_component('percorsi_fatture','percorsi_fatture',{id_cliente:oggetti['id_cliente']});
        });
    },
});