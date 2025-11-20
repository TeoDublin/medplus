function parseFilter(){
    let ret = {};
    let alerts = [];
    let scadenza_da = document.querySelector('#scadenza_da').value;
    let scadenza_a = document.querySelector('#scadenza_a').value;
    let scadenza_all = document.querySelector('#scadenza_all').checked;
    let data_pagamento_da = document.querySelector('#data_pagamento_da').value;
    let data_pagamento_a = document.querySelector('#data_pagamento_a').value;
    let data_pagamento_all = document.querySelector('#data_pagamento_all').checked;


    if(scadenza_da !== '' && scadenza_a !== ''){
        if(scadenza_a<scadenza_da){
            alerts.push("Data fine non puo essere inferiore alla data Inizio");
        }
    }

    if (scadenza_da !== '' || scadenza_a !== '' || scadenza_all ==true ) {
        ret.scadenza = {};
        if (scadenza_all == true) ret.scadenza.all = scadenza_all;
        else{
            if (scadenza_da !== '') ret.scadenza.da = scadenza_da;
            if (scadenza_a !== '') ret.scadenza.a = scadenza_a;    
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

    let stato_pagamento = $('#stato_pagamento').val() || [];
    if (stato_pagamento.length > 0) {
        ret.stato_pagamento = stato_pagamento;
    }

    let tipo_pagamento = $('#tipo_pagamento').val() || [];
    if (tipo_pagamento.length > 0) {
        ret.tipo_pagamento = tipo_pagamento;
    }

    let realizzato_da = $('#realizzato_da').val() || [];
    if (realizzato_da.length > 0) {
        ret.realizzato_da = realizzato_da;
    }

    let bnw = $('#bnw').val() || [];
    if (bnw.length > 0) {
        ret.bnw = bnw;
    }

    let stato_saldato_terapista = $('#stato_saldato_terapista').val() || [];
    if (stato_saldato_terapista.length > 0) {
        ret.stato_saldato_terapista = stato_saldato_terapista;
    }

    let id_terapista = $('#id_terapista').val() || [];
    if (id_terapista.length > 0) {
        ret.id_terapista = id_terapista;
        ret.terapista = $('#id_terapista option:selected').map(function(){return $(this).text()}).get();
    }

    let cliente = $('#cliente').val() || [];
    if (cliente.length > 0) {
        ret.cliente = cliente;
        ret.nominativo = $('#cliente option:selected').map(function(){return $(this).text()}).get();
    }

    if(alert.length>0){
        alert(alerts.join('\n'));       
    }

    return ret;
}

function btnFiltra() {
    $.post('post/component/corsi.php?pagination=0', parseFilter())
    .done(response => { loadView(response);});
}

function btnClean(){
    $.post('post/component/corsi.php?pagination=0', {'btnClean':true} ).done(response => { loadView(response);});
}

function loadView(response){
    document.querySelector('#spa_corsi').innerHTML = response;
    const floatingMenu = document.querySelector('.floating-menu');
    const floatingMenuBtn = document.querySelector('.floating-menu-btn');
    const floatingDownloadPdfBtn = document.querySelector('.floating-download-pdf-btn');
    const floatingExcelBtn = document.querySelector('.floating-excel-btn');

    floatingMenuBtn.addEventListener('click', () => {
        floatingMenu.classList.toggle('open');
        floatingMenuBtn.classList.toggle('open');
        floatingDownloadPdfBtn.classList.toggle('open');
        floatingExcelBtn.classList.toggle('open');
    });

    document.querySelectorAll('a.page-link').forEach(link => {
        link.addEventListener('click', event => {
            event.preventDefault();
            let page = parseInt(event.target.dataset.n) - 1;
            $.post('post/component/corsi.php?pagination=' + page, parseFilter()).done(response => loadView(response));
        });
    });

    document.querySelectorAll('.selectpicker').forEach(el => {
        const $el = $(el);
        if (!$el.hasClass('active-selectpicker')) {
            $('.selectpicker').selectpicker({
                liveSearch: true,
                noneSelectedText: 'Tutti',
                actionsBox: true,
                selectAllText: 'Seleziona tutto',
                deselectAllText: 'Deseleziona tutto',
                width: 300
            });
            $el.addClass('active-selectpicker');
        }
    });

}

function inputExcel(){
    modal_component('input_excel_corsi','input_excel_corsi',{});
}

document.addEventListener('DOMContentLoaded',function(){
    $.post('post/component/corsi.php?pagination=0', {} ).done(response => { loadView(response);});
});
