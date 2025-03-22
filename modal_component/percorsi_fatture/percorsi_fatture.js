window.modalHandlers['percorsi_fatture']={
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
    enterStato:function(element){
        element.classList.add('successSingle');
    },
    leaveStato:function(element){
        element.classList.remove('successSingle');
    },
    changeStato:function(stato,id){
        $.post('post/save.php',{table:'fatture',stato:stato,id:id}).done(()=>{success()}).fail(()=>{fail()});
    },
}
