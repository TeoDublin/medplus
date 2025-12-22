window.modalHandlers['uscita']={
    btnSalva:function(element){
        const div = document.createElement('div');
        div.id = 'btnSalva';
        div.innerHTML = spinner();
        document.body.appendChild(div);

        let _save_data = save_data(element);
        let _load_data = load_data(element);
        let _data = {
            table:'uscite_uscita',
            save_data:_save_data, 
            load_data:_load_data,
            id_alias:'id_uscita'
        };

        $.post('post/save_n_response.php',_data)
        .done(response=>{

            reload_modal_component('add_uscita','add_uscita',response);

        })
        .fail(()=>fail())
        .always(()=>{div.remove();});
        
    }
};
