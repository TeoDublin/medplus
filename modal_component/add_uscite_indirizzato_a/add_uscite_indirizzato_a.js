window.modalHandlers['indirizzato_a']={
    btnSalva:function(element){
        let _save_data = save_data(element); 
        _save_data.table = 'uscite_indirizzato_a';
        const id_uscita = _save_data.id_uscita;
        delete _save_data.id_uscita;

        $.post('post/save.php',_save_data).done((id)=>{ 

            let _data = {
                id_indirizzato_a:id
            }

            if(id_uscita !== ''){
                _data.id = id_uscita;
            }

            reload_modal_component('add_uscita','add_uscita',_data);
        }).fail(()=>{
            fail();
        });
    }
};
