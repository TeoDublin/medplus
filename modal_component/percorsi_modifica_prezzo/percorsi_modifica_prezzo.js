window.modalHandlers['percorsi_modifica_prezzo']={
    btnSalva:function(element){
        const mnodal = element.closest('.modal');
        const request = mnodal.querySelector('#request').textContent;
        let _data = JSON.parse(request ?? '{}');
        mnodal.querySelectorAll('[name]').forEach(element=>{ _data[element.name]=element.value;});
        $.post('post/percorsi_modifica_prezzo.php',_data).done(()=>{ 
            reload_modal_component('percorsi_pendenze','percorsi_pendenze',{id_cliente:_data['id_cliente']});
        }).fail(()=>{fail()});
    }
} 
