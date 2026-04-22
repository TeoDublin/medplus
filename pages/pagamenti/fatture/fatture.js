function parseFilter(){

    let ret = {'unset':'btnClean'};
    let alerts = [];
    let index = document.querySelector('#index').value;

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

    let cliente = $('#cliente').val() || [];
    if (cliente.length > 0) {
        ret.cliente = cliente;
        ret.nominativo = $('#cliente option:selected').map(function(){return $(this).text()}).get();
    }

    let stato = $('#stato').val() || [];
    if (stato.length > 0) {
        ret.stato = stato;
    }

    if(index!==''){
        ret.index=index;
    }

    if(alert.length>0){
        alert(alerts.join('\n'));       
    }
    
    return ret;
}

function btnFiltra() {
    $.post('pages/pagamenti/fatture/post/fatture.php?pagination=0', parseFilter())
    .done(response => { loadView(response);});
}

function btnClean(){
    $.post('pages/pagamenti/fatture/post/fatture.php?pagination=0', {'btnClean':true, 'cookie':{'btnClean':1}} ).done(response => { loadView(response);});
}

function loadView(response){

    document.querySelector('#spa_fatture').innerHTML = response;
    const floatingMenu = document.querySelector('.floating-menu');
    const floatingMenuBtn = document.querySelector('.floating-menu-btn');
    const floatingInputFatture = document.querySelector('.floating-input-fatture');
    const floatinfloatingDownloadFatture = document.querySelector('.floating-download-fatture-btn');
    const floatingExcelBtn = document.querySelector('.floating-excel-btn');

    floatingMenuBtn.addEventListener('click', () => {
        floatingMenu.classList.toggle('open');
        floatingMenuBtn.classList.toggle('open');
        floatingInputFatture.classList.toggle('open');
        floatinfloatingDownloadFatture.classList.toggle('open');
        floatingExcelBtn.classList.toggle('open');
    });

    document.querySelectorAll('a.page-link').forEach(link => {
        link.addEventListener('click', event => {
            event.preventDefault();
            let page = parseInt(event.target.innerHTML) - 1;
            $.post('pages/pagamenti/fatture/post/fatture.php?pagination=' + page, parseFilter()).done(response => loadView(response));
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
    modal_component('input_excel_fatture','input_excel_fatture',{});
}
document.addEventListener('DOMContentLoaded',function(){
    $.post('pages/pagamenti/fatture/post/fatture.php?pagination=0', {} ).done(response => { loadView(response);});
});
