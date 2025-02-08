window.modalHandlers['prezzo_corso'] = {
    btnSalva:function(element,id,id_cliente){
        $.post('post/save.php',{table:'corsi_pagamenti',id:id,prezzo:element.closest('.modal').querySelector('#prezzo').value}).done(()=>{
            modal_component('percorsi_pendenze','percorsi_pendenze',{id_cliente:id_cliente});
        }).fail(()=>{fail()});
    }
}