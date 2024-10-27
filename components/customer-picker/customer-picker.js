function selectNominativo(event, _nominativo){
    const rect = event.target.getBoundingClientRect();
    const x = rect.x + window.scrollX;
    const y = rect.y + window.scrollY +40;
    const w = _nominativo.clientWidth;
    $.ajax({
        url:'/medplus/components/customer-picker/customer-picker.ctrl.php',
        type:'POST',
        data:{
            action: 'select-nominativo',
            nominativo: _nominativo.value
        },
        dataType:'json',
        success:function(response){
            document.querySelectorAll('#nominativo_select').forEach((element)=>{element.remove();});
            const content = document.createElement('div');
            content.id='nominativo_select';
            content.classList.add('bg-body-tertiary','p-1','pt-0','border');
            content.setAttribute('style', 'left:'+x+'px;top:'+y+'px;position:absolute;width:'+w+'px;z-index:99999');
            response.forEach(item => {
                const div = document.createElement('div');
                div.textContent = item.nominativo;
                div.classList.add('form-control','hover','w-100','mt-1');
                div.addEventListener('click', function() {
                    _nominativo.value = item.nominativo;
                    document.querySelector('#cf').value = item.cf;
                    document.querySelector('#telefono').value = item.telefono;
                    document.querySelector('#celulare').value = item.celulare;
                    document.querySelector('#email').value = item.email;
                    document.querySelector('#indirizzo').value = item.indirizzo;
                    document.querySelector('#citta').value = item.citta;
                    document.querySelector('#cap').value = item.cap;
                    document.querySelector('#tipo').value = item.tipo;
                    document.querySelector('#portato_da').value = item.portato_da;
                    document.querySelector('#data_inserimento').value = item.data_inserimento;
                    document.querySelector('#prestazioni_precedenti').value = item.prestazioni_precedenti;
                    document.querySelector('#notizie_cliniche').value = item.notizie_cliniche;
                    document.querySelector('#note_tratammento').value = item.note_tratammento;
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
        },
        error: function(xhr, status, error) {
            console.error("Error:", status, error);
        }
    });
}