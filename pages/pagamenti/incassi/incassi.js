function parseFilter(){
    let ret = {'unset':'btnClean'};
    let alerts = [];
    let data_creazione_da = document.querySelector('#data_creazione_da').value;
    let data_creazione_a = document.querySelector('#data_creazione_a').value;
    let data_creazione_all = document.querySelector('#data_creazione_all').checked;

    if(data_creazione_da !== '' && data_creazione_a !== ''){
        if(data_creazione_a<data_creazione_da){
            alerts.push("Data fine non puo essere inferiore alla data Inizio");
        }
    }

    if (data_creazione_da !== '' || data_creazione_a !== '' || data_creazione_all ==true ) {
        ret.data_creazione = {};
        if (data_creazione_all == true) ret.data_creazione.all = data_creazione_all;
        else{
            if (data_creazione_da !== '') ret.data_creazione.da = data_creazione_da;
            if (data_creazione_a !== '') ret.data_creazione.a = data_creazione_a;    
        }
    }

    let realizzato_da = $('#realizzato_da').val() || [];
    if (realizzato_da.length > 0) {
        ret.realizzato_da = realizzato_da;
    }

    let fattura_aruba = $('#fattura_aruba').val() || [];
    if (fattura_aruba.length > 0) {
        ret.fattura_aruba = fattura_aruba;
    }

    let stato = $('#stato').val() || [];
    if (stato.length > 0) {
        ret.stato = stato;
    }

    let origine = $('#origine').val() || [];
    if (origine.length > 0) {
        ret.origine = origine;
    }

    let metodo = $('#metodo').val() || [];
    if (metodo.length > 0) {
        ret.metodo = metodo;
    }

    let voucher = $('#voucher').val() || [];
    if (voucher.length > 0) {
        ret.voucher = voucher;
    }

    let tipo_pagamento = $('#tipo_pagamento').val() || [];
    if (tipo_pagamento.length > 0) {
        ret.tipo_pagamento = tipo_pagamento;
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
    $.post('pages/pagamenti/incassi/post/incassi.php?pagination=0', parseFilter())
    .done(response => { loadView(response);});
}

function btnClean(){
    $.post('pages/pagamenti/incassi/post/incassi.php?pagination=0', {'btnClean':true, 'cookie':{'btnClean':1}} ).done(response => { loadView(response);});
}

function loadView(response){
    
    document.querySelector('#spa_incassi').innerHTML = response;
    const floatingMenu = document.querySelector('.floating-menu');
    const floatingMenuBtn = document.querySelector('.floating-menu-btn');
    const floatingExcelBtn = document.querySelector('.floating-excel-btn');

    floatingMenuBtn.addEventListener('click', () => {
        floatingMenu.classList.toggle('open');
        floatingMenuBtn.classList.toggle('open');
        floatingExcelBtn.classList.toggle('open');
    });

    document.querySelectorAll('a.page-link').forEach(link => {
        link.addEventListener('click', event => {
            event.preventDefault();
            let page = parseInt(event.target.dataset.n) - 1;
            $.post('pages/pagamenti/incassi/post/incassi.php?pagination=' + page, parseFilter()).done(response => loadView(response));
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

document.addEventListener('DOMContentLoaded',function(){
    $.post('pages/pagamenti/incassi/post/incassi.php?pagination=0', {} ).done(response => { loadView(response);});
});
