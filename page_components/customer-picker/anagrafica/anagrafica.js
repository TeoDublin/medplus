function selectNominativo(event, nominativo){
    $.post({url: 'post/select-nominativo.php',data:{ skip_cookie:true, nominativo: nominativo.value},dataType:'json'})
        .done(response=>{cp_success(event,nominativo,response);})
        .fail(()=>fail());
}
function cp_success(event,nominativo,response){
    const rect = event.target.getBoundingClientRect();
    const x = rect.x + window.scrollX;
    const y = rect.y + window.scrollY +40;
    const w = nominativo.clientWidth;
    document.querySelectorAll('#nominativo_select').forEach((element)=>{element.remove();});
    const content = document.createElement('div');
    content.id='nominativo_select';
    content.classList.add('bg-body-tertiary','p-1','pt-0','border');
    content.setAttribute('style', 'left:'+x+'px;top:'+y+'px;position:absolute;width:'+w+'px;z-index:99999');
    if(response.length>0){
        response.forEach(item => {
            const div = document.createElement('div');
            div.textContent = item.nominativo;
            div.classList.add('form-control','hover','w-100','mt-1');
            div.addEventListener('click', function() {
                nominativo.value = item.nominativo;
                Object.keys(item).forEach(key => {
                    const input = document.querySelector(`[name="${key}"]`);
                    if (input) {
                        input.value = item[key];
                    }
                });
                content.remove();
            });                    
            content.appendChild(div);
            toggleBtnSalva(nominativo);
        });
        document.body.appendChild(content);
        document.addEventListener('click', function onClickOutside(event) {
            if (!content.contains(event.target) && event.target !== nominativo) {
                content.remove();
                document.removeEventListener('click', onClickOutside);
            }
            toggleBtnSalva(nominativo);
        });
    }
    else{
        document.querySelectorAll('[name]:not(meta):not(#nominativo):not(#data_inserimento)').forEach(item=>{ item.value='';});
        toggleBtnSalva(nominativo);
    }
    document.querySelector('#modal_body_prenota').querySelectorAll('.nav-item:not(.anagrafica)').forEach(item=>{ 
        if(!item.getAttribute('hidden')){
            item.setAttribute('hidden','');
        }
    });
}
function cellulareChange(){
    toggleBtnSalva(document.querySelector('#nominativo'));
}
function toggleBtnSalva(nominativo){
    const btnSalvaCliente = document.querySelector('#btnSaveCliente');
    if(nominativo.value!=''&&document.querySelector('#cellulare').value!=''){
        btnSalvaCliente.classList.remove('disabled');
    }
    else {
        if(!btnSalvaCliente.classList.contains('disabled')){
            btnSalvaCliente.classList.add('disabled');
        }
    }
    
}
function btnSalva(){
    const _data={'table':'clienti'};
    const _tab=document.querySelector('#modal_body_prenota');
    const _modalBody=document.querySelector('#modal_body_prenota');
    _tab.querySelectorAll('[name]').forEach(item=>{ _data[item.getAttribute('name')]=item.value;});
    $.post('post/save.php',_data).done(insert_id=>{
        _modalBody.querySelectorAll('.nav-link').forEach(nav=>{ 
            let _target = nav.getAttribute('target');
            if(!_target.includes('id_cliente')){
                nav.setAttribute('target',_target+'&id_cliente='+insert_id);
            }
            else{
                _target = _target.replace(/id_cliente=\d+/g, `id_cliente=${insert_id}`);
                nav.setAttribute('target',_target);
            }
            document.querySelector('.trattamenti').removeAttribute('hidden');
            parent._tab(document.querySelector('[tab=trattamenti]'));
        });
        _modalBody.querySelectorAll('.nav-item').forEach(item=>{ item.removeAttribute('hidden');});
        success();
    }).fail(()=>{fail();});
}