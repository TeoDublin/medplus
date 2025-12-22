window.modalHandlers['add_uscita']={
    btnSalva: function (element) {
        const _validate = validate(element);
        if (_validate.has_error) {
            return;
        }

        const _save_data = save_data(element);

        const files = [];
        document.querySelectorAll('.div-files').forEach(file => {
            files.push({ ...file.dataset });
        });

        _save_data.files = JSON.stringify(files);

        $.post('post/add_uscita_save.php', _save_data)
            .done(() => {
                success_and_refresh();
            })
            .fail(() => {
                fail();
            });
    },
    viewFileEnter:function(element){
        element.classList.add('fileHover');
    },
    viewFileClick:function(element){
        if(element.querySelector('.btnDel').classList.contains('delFileEnter')){
            if(confirm('Sicuro di voler eliminare ?')){
                $.post('post/add_uscita_delete_file.php',element.dataset).done(()=>{
                    element.remove();
                }).fail(()=>{
                    fail();
                });
            }
        }
    },
    delFileEnter:function(element){
        element.classList.add('delFileEnter');
    },
    delFileLeave:function(element){
        element.classList.remove('delFileEnter');
    },
    addFile:function(element){

        const div = document.createElement('div');
        div.id = 'addFile';
        div.style = 'z-index:99999!important';
        div.innerHTML = spinner();
        document.querySelector('#modal_add_uscita').appendChild(div);

        const modal = element.closest('.modal');
        const input = modal.querySelector('#uscite_files');
        const files = input.files;

        if (files.length === 0) {
            div.remove();
            return alert('Seleziona qualcosa');
        }

        const formData = new FormData();
        formData.append('isJS', 'true');

        for (let i = 0; i < files.length; i++) {
            formData.append('files[]', files[i]);
        }

        $.ajax({
            url: 'post/add_uscita_file.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false
        })
        .done(html => {
            const list = modal.querySelector('#uscite_files_list');
            list.insertAdjacentHTML('beforeend', html);
        })
        .fail(() => {
            fail();
        })
        .always(()=>{
            div.remove();
        });
    },
    addCategoria:function(element){
        let _save_data = save_data(element);
        delete(_save_data.id_categoria);
        modal_component('add_uscite_categoria','add_uscite_categoria',_save_data);
    },
    editCategoria:function(element){
        let _save_data = save_data(element);

        if( typeof _save_data.id_categoria === 'undefined' ){
            return alert('Seleziona qualcosa');   
        }

        modal_component('add_uscite_categoria','add_uscite_categoria',_save_data);
    },
    delCategoria:function(element){
        const div = document.createElement('div');
        div.id = 'delCategoria';
        div.innerHTML = spinner();
        document.body.appendChild(div);

        let _save_data = save_data(element);

        if(typeof _save_data.id_categoria === 'undefined'){
            alert('Seleziona qualcosa');
            div.remove();
        }
        else{
            $.post('post/btn_del_categoria.php',_save_data).done(response=>{
                
                msg = response.msg;

                if(msg != 'success' ){
                    return alert(msg);
                }

                reload_modal_component('add_uscita','add_uscita',response);

            })
            .fail(()=>fail())
            .always(()=>{div.remove();});
        }

        
    },
    addUscita:function(element){
        let _save_data = save_data(element);
        delete(_save_data.id_uscita);
        modal_component('add_uscite_uscita','add_uscite_uscita',_save_data);
    },
    editUscita:function(element){
        let _save_data = save_data(element);

        if( typeof _save_data.id_uscita === 'undefined' ){
            return alert('Seleziona qualcosa');   
        }

        modal_component('add_uscite_uscita','add_uscite_uscita',_save_data);
    },
    delUscita:function(element){
        const div = document.createElement('div');
        div.id = 'delUscita';
        div.innerHTML = spinner();
        document.body.appendChild(div);

        let _save_data = save_data(element);

        if(typeof _save_data.id_uscita === 'undefined'){
            alert('Seleziona qualcosa');
        }
        else{
            $.post('post/btn_del_uscita.php',_save_data).done(response=>{
                
                msg = response.msg;

                if(msg != 'success' ){
                    return alert(msg);
                }

                reload_modal_component('add_uscita','add_uscita',response);

            }).fail(()=>fail());
        }

        div.remove();
    },
    addIndirizzato_a:function(element){
        let _save_data = save_data(element);
        delete(_save_data.id_indirizzato_a);
        modal_component('add_uscite_indirizzato_a','add_uscite_indirizzato_a',_save_data);
    },
    editIndirizzato_a:function(element){
        let _save_data = save_data(element);

        if( typeof _save_data.id_indirizzato_a === 'undefined' ){
            return alert('Seleziona qualcosa');   
        }

        modal_component('add_uscite_uscita','add_uscite_uscita',_save_data);
    },
    delIndirizzato_a:function(element){
        const div = document.createElement('div');
        div.id = 'indirizzato_a';
        div.innerHTML = spinner();
        document.body.appendChild(div);

        let _save_data = save_data(element);

        if(typeof _save_data.id_indirizzato_a === 'undefined'){
            alert('Seleziona qualcosa');
        }
        else{
            $.post('post/btn_del_indirizzato_a.php',_save_data).done(response=>{

                msg = response.msg;

                if(msg != 'success' ){
                    return alert(msg);
                }

                reload_modal_component('add_uscita','add_uscita',response);

            }).fail(()=>fail());
        }

        div.remove();
    },
    changeDataPagamento:function(element){
        element.closest('.modal').querySelector('[name=voucher]').value = 'Seleziona';
        element.closest('.modal').querySelectorAll('[name=voucher] option').forEach((e)=>{
            if(element.value != 'Contanti' && e.value == 'No'){
                e.setAttribute('disabled','disabled');
            }
            else{
                e.removeAttribute('disabled');
            }
        });
        
    }
} 
