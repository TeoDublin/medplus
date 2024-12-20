function selectNominativo(event, _nominativo){
    $.post({url: 'post/select-nominativo.php',data:{ skip_cookie:true, nominativo: _nominativo.value},dataType:'json'}).done(response=>{cp_success(event,_nominativo,response);}).fail(error=>{fail();});
}
function cp_success(event,_nominativo,response){
    const rect = event.target.getBoundingClientRect();
    const x = rect.x + window.scrollX;
    const y = rect.y + window.scrollY +40;
    const w = _nominativo.clientWidth;
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
                _nominativo.value = item.nominativo;
                Object.keys(item).forEach(key => {
                    const input = document.querySelector(`[name="${key}"]`);
                    if (input) {
                        input.value = item[key];
                    }
                });
                content.remove();
            });                    
            content.appendChild(div);
        });
        document.body.appendChild(content);
        document.addEventListener('click', function onClickOutside(event) {
            if (!content.contains(event.target) && event.target !== _nominativo) {
                content.remove();
                document.removeEventListener('click', onClickOutside);
            }
        });
    }
    else document.querySelectorAll('[name]:not(#nominativo) [name]:not(#sedute) [name]:not(#prezzo)').forEach(item=>{ item.value='';});
}