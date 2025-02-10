window.modalHandlers['add_sedute'] = {
    btnSalva:function(element,id_cliente,id_percorso,id_trattamento){
        $.post('post/add_sedute.php',{
            id_cliente:id_cliente,
            id_percorso:id_percorso,
            id_trattamento:id_trattamento,
            qtt:element.closest('.modal').querySelector('#qtt').value
        }).done(()=>{
            reload_modal_component('percorsi','percorsi',{id_cliente:id_cliente});
        }).fail(()=>{
            fail();
        });
    }
}