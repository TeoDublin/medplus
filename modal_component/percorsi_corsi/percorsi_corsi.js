window.modalHandlers['percorsi_corsi'] = {
    delEnter:function(element){
        element.closest('.flex-row').classList.add('warning');
    },
    delLeave:function(element){
        element.closest('.flex-row').classList.remove('warning');
    },
    delClick:function(id,id_cliente){
        if(confirm('sicuro di voler eliminare ?')){
            $.post('post/delete.php',{table:'corsi_classi',id:id}).done(()=>{
                reload_modal_component('percorsi_corsi','percorsi_corsi',{id_cliente:id_cliente})
            }).fail(()=>{fail();})
        }
    },
}