window.modalHandlers['senza_fattura']={
    btnSalva:function(element,_percorsi){
        let _data = {};
        const mnodal = element.closest('.modal');
        mnodal.querySelectorAll('[name]').forEach(element=>{ _data[element.name]=element.value;});
        $.post('post/senza_fattura.php',{percorsi:_percorsi,_data:_data}).done(function(){ 
            modal_component('percorsi_pagamenti','percorsi_pagamenti',{id_cliente:_data['id_cliente']});
        }).fail(function(){fail()});
    }
} 
