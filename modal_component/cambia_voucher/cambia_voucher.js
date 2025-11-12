window.modalHandlers['cambia_voucher']={
    btnSalva:function(element){
        const save = element.closest('.modal').querySelector('.save');
        let _data = save.dataset;
        save.querySelectorAll('[name]').forEach(element=>{ _data[element.name]=element.value;});
        $.post('post/save.php',{'table':'percorsi_terapeutici','bnw':_data.bnw,id:_data.id_percorso}).done(function(){ 
            reload_modal_component('percorsi','percorsi',{id_cliente:_data.id_cliente});
        }).fail(function(){
            fail();
        });
    }
} 
