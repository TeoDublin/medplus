function parseFilter(){
    let ret = {'unset':'btnClean'};
    let alerts = [];
    let data_seduta_da = document.querySelector('#data_seduta_da').value;
    let data_seduta_a = document.querySelector('#data_seduta_a').value;
    let data_seduta_all = document.querySelector('#data_seduta_all').checked;
    let data_pagamento_da = document.querySelector('#data_pagamento_da').value;
    let data_pagamento_a = document.querySelector('#data_pagamento_a').value;
    let data_pagamento_all = document.querySelector('#data_pagamento_all').checked;


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

    let stato_seduta = $('#stato_seduta').val() || [];
    if (stato_seduta.length > 0) {
        ret.stato_seduta = stato_seduta;
    }

    let stato_pagamento = $('#stato_pagamento').val() || [];
    if (stato_pagamento.length > 0) {
        ret.stato_pagamento = stato_pagamento;
    }

    let metodo = $('#metodo').val() || [];
    if (metodo.length > 0) {
        ret.metodo = metodo;
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
    $.post('pages/pagamenti/sedute/post/sedute.php?pagination=0', parseFilter())
    .done(response => { loadView(response);});
}

function btnClean(){
    $.post('pages/pagamenti/sedute/post/sedute.php?pagination=0', {'btnClean':true, 'cookie':{'btnClean':1}} ).done(response => { loadView(response);});
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
            $.post('pages/pagamenti/sedute/post/sedute.php?pagination=' + page, parseFilter()).done(response => loadView(response));
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
    modal_component('input_excel_sedute','input_excel_sedute',{});
}

document.addEventListener('DOMContentLoaded',function(){
    $.post('pages/pagamenti/sedute/post/sedute.php?pagination=0', {} ).done(response => { loadView(response);});
});
