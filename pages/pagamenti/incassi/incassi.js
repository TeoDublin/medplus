function parseFilter(){
    let ret = {'unset':'btnClean'};
    let alerts = [];
    let data_da = document.querySelector('#data_da').value;
    let data_a = document.querySelector('#data_a').value;
    let data_all = document.querySelector('#data_all').checked;

    if(data_da !== '' && data_a !== ''){
        if(data_a<data_da){
            alerts.push("Data fine non puo essere inferiore alla data Inizio");
        }
    }

    if (data_da !== '' || data_a !== '' || data_all ==true ) {
        ret.data = {};
        if (data_all == true) ret.data.all = data_all;
        else{
            if (data_da !== '') ret.data.da = data_da;
            if (data_a !== '') ret.data.a = data_a;    
        }
    }

    let stato = $('#stato').val() || [];
    if (stato.length > 0) {
        ret.stato = stato;
    }

    let origine = $('#origine').val() || [];
    if (origine.length > 0) {
        ret.origine = origine;
    }

    let bnw = $('#bnw').val() || [];
    if (bnw.length > 0) {
        ret.bnw = bnw;
    }

    let metodo = $('#metodo').val() || [];
    if (metodo.length > 0) {
        ret.metodo = metodo;
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
    $.post('pages/pagamenti/incassi/post_component/incassi.php?pagination=0', parseFilter())
    .done(response => { loadView(response);});
}

function btnClean(){
    $.post('pages/pagamenti/incassi/post_component/incassi.php?pagination=0', {'btnClean':true, 'cookie':{'btnClean':1}} ).done(response => { loadView(response);});
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
            $.post('pages/pagamenti/incassi/post_component/incassi.php?pagination=' + page, parseFilter()).done(response => loadView(response));
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
    $.post('pages/pagamenti/incassi/post_component/incassi.php?pagination=0', {} ).done(response => { loadView(response);});
});
