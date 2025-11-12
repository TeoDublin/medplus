window.modalHandlers['percorsi_fatture']={
    delEnter:function(e){
        e.closest('.accordion-row').querySelector('.accordion').classList.add('bg-warning');
    },
    delLeave:function(e){
        e.closest('.accordion-row').querySelector('.accordion').classList.remove('bg-warning');
    },
    delClick:function(e){
        if(confirm('Sicuro di volere eliminare ?')){
            $.post('post/delete_percorsi_fatture.php',e.dataset).done(()=>{
                reload_modal_component('percorsi_fatture','percorsi_fatture',{id_cliente:e.dataset.id_cliente});
            }).fail(()=>{fail()});
        }
    },
    statoChange:function(e){
        modal_component('fattura_cambia_stato','fattura_cambia_stato',e.dataset);
    }
};