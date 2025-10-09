function parseFilter(){
    let ret = {};
    let alerts = [];
    let data_seduta_da = document.querySelector('#data_seduta_da').value;
    let data_seduta_a = document.querySelector('#data_seduta_a').value;
    let data_seduta_all = document.querySelector('#data_seduta_all').checked;
    let data_pagamento_da = document.querySelector('#data_pagamento_da').value;
    let data_pagamento_a = document.querySelector('#data_pagamento_a').value;
    let data_pagamento_all = document.querySelector('#data_pagamento_all').checked;
    let id_terapista = document.querySelector('#id_terapista').value;
    let stato_seduta = document.querySelector('#stato_seduta').value;
    let stato_pagamento = document.querySelector('#stato_pagamento').value;
    let tipo_pagamento = document.querySelector('#tipo_pagamento').value;
    let realizzato_da = document.querySelector('#realizzato_da').value;
    let stato_saldato_terapista = document.querySelector('#stato_saldato_terapista').value;
    let cliente = document.querySelector('#cliente').value;
    let nominativo = document.querySelector('#cliente option:checked').innerHTML;

    if(data_seduta_da !== '' && data_seduta_a !== ''){
        if(data_seduta_a<data_seduta_da){
            alerts.push("Data fine non puo essere inferiore alla data Inizio");
        }
    }
    if (data_seduta_da !== '' || data_seduta_a !== '' || data_seduta_all ==true ) {
        ret.data_seduta = {};
        if (data_seduta_all == true) ret.data_seduta.all = data_seduta_all;
        else{
            if (data_seduta_da !== '') ret.data_seduta.da = data_seduta_da;
            if (data_seduta_a !== '') ret.data_seduta.a = data_seduta_a;    
        }
    }
    if(data_pagamento_da !== '' && data_pagamento_a !== ''){
        if(data_pagamento_a<data_pagamento_da){
            alerts.push("Data fine non puo essere inferiore alla data Inizio");
        }
    }
    if (data_pagamento_da !== '' || data_pagamento_a !== '' || data_pagamento_all ==true ) {
        ret.data_pagamento = {};
        if (data_pagamento_all == true) ret.data_pagamento.all = data_pagamento_all;
        else{
            if (data_pagamento_da !== '') ret.data_pagamento.da = data_pagamento_da;
            if (data_pagamento_a !== '') ret.data_pagamento.a = data_pagamento_a;    
        }
    }
    if(id_terapista!==''){
        ret.id_terapista = id_terapista;
        ret.terapista=document.querySelector('#id_terapista').selectedOptions[0].text;
    }
    if(stato_seduta!=='')ret.stato_seduta=stato_seduta;

    if(stato_pagamento!=='')ret.stato_pagamento=stato_pagamento;
    if(tipo_pagamento!=='')ret.tipo_pagamento=tipo_pagamento;
    if(realizzato_da!=='')ret.realizzato_da=realizzato_da;
    if(stato_saldato_terapista!=='')ret.stato_saldato_terapista=stato_saldato_terapista;

    if(cliente!=='')ret.cliente=cliente;
    if(nominativo!=='')ret.nominativo=nominativo;

    if(alert.length>0){
        alert(alerts.join('\n'));       
    }
    return ret;
}
function btnFiltra() {
    $.post('post/component/sedute.php?pagination=0', parseFilter())
    .done(response => { loadView(response);});
}
function btnClean(){
    $.post('post/component/sedute.php?pagination=0', {'btnClean':true} ).done(response => { loadView(response);});
}
function loadView(response){
    document.querySelector('#spa_sedute').innerHTML = response;
    const floatingMenu = document.querySelector('.floating-menu');
    const floatingMenuBtn = document.querySelector('.floating-menu-btn');
    const floatingInputSedute = document.querySelector('.floating-input-sedute');
    const floatingDownloadPdfBtn = document.querySelector('.floating-download-pdf-btn');
    const floatingExcelBtn = document.querySelector('.floating-excel-btn');
    floatingMenuBtn.addEventListener('click', () => {
        floatingMenu.classList.toggle('open');
        floatingMenuBtn.classList.toggle('open');
        floatingInputSedute.classList.toggle('open');
        floatingDownloadPdfBtn.classList.toggle('open');
        floatingExcelBtn.classList.toggle('open');
    });
    document.querySelectorAll('a.page-link').forEach(link => {
        link.addEventListener('click', event => {
            event.preventDefault();
            let page = parseInt(event.target.dataset.n) - 1;
            $.post('post/component/sedute.php?pagination=' + page, parseFilter()).done(response => loadView(response));
        });
    });
    document.querySelector('#filter_cliente').querySelector('select#cliente').searchable();
    
}
function inputExcel(){
    modal_component('input_excel_sedute','input_excel_sedute',{});
}
document.addEventListener('DOMContentLoaded',function(){
    $.post('post/component/sedute.php?pagination=0', {} ).done(response => { loadView(response);});
});
