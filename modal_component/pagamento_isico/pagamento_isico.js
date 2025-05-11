window.modalHandlers['pagamento_isico']={
    btnSalva:function(element,_percorsi){
        let _data = {};
        const mnodal = element.closest('.modal');
        mnodal.querySelectorAll('[name]').forEach(element=>{ _data[element.name]=element.value;});
        $.post('post/pagamento_isico.php',{percorsi:_percorsi,_data:_data}).done(function(){ 
            reload_modal_component('percorsi_pendenze','percorsi_pendenze',{id_cliente:_data['id_cliente']});
        }).fail(function(){fail()});
    }
} 
