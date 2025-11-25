window.modalHandlers['add_uscita']={
    btnSalva:function(element){
        let _save_data = save_data(element);
        _save_data.table = 'uscite_registrate';
        $.post('post/save.php',_save_data).done(()=>{ 
            success_and_refresh();
        }).fail(()=>{
            fail();
        });
    },
    categoria:function(element,add){
        let _save_data = save_data(element);
        if(add){
            delete(_save_data.id_categoria);
        }
        modal_component('add_uscite_categoria','add_uscite_categoria',_save_data);
    },
    uscita:function(element,add){
        let _save_data = save_data(element);
        if(add){
            delete(_save_data.id_uscita);
        }
        modal_component('add_uscite_uscita','add_uscite_uscita',_save_data);
    },
    indirizzato_a:function(element,add){
        let _save_data = save_data(element);
        if(add){
            delete(_save_data.id_indirizzato_a);
        }
        modal_component('add_uscite_indirizzato_a','add_uscite_indirizzato_a',_save_data);
    }
} 
