function parseFilter(){
    let ret = {};
    let alerts = [];
    let data_da = document.querySelector('#data_da').value;
    let data_a = document.querySelector('#data_a').value;
    let data_all = document.querySelector('#data_all').checked;
    let stato = document.querySelector('#stato').value;
    let origine = document.querySelector('#origine').value;
    let bnw = document.querySelector('#bnw').value;
    let metodo = document.querySelector('#metodo').value;
    let cliente = document.querySelector('#cliente').value;
    let nominativo = document.querySelector('#cliente option:checked').innerHTML;

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

    if(stato!=='')ret.stato=stato;
    if(origine!=='')ret.origine=origine;
    if(bnw!=='')ret.bnw=bnw;
    if(metodo!=='')ret.metodo=metodo;

    if(cliente!=='')ret.cliente=cliente;
    if(nominativo!=='')ret.nominativo=nominativo;

    if(alert.length>0){
        alert(alerts.join('\n'));       
    }
    return ret;
}

function btnFiltra() {
    $.post('post/component/incassi.php?pagination=0', parseFilter())
    .done(response => { loadView(response);});
}

function btnClean(){
    $.post('post/component/incassi.php?pagination=0', {'btnClean':true} ).done(response => { loadView(response);});
}

function loadView(response){
    document.querySelector('#spa_incassi').innerHTML = response;
    const floatingMenu = document.querySelector('.floating-menu');
    const floatingMenuBtn = document.querySelector('.floating-menu-btn');
    const floatingInputincassi = document.querySelector('.floating-input-incassi');
    const floatingDownloadPdfBtn = document.querySelector('.floating-download-pdf-btn');
    const floatingExcelBtn = document.querySelector('.floating-excel-btn');
    floatingMenuBtn.addEventListener('click', () => {
        floatingMenu.classList.toggle('open');
        floatingMenuBtn.classList.toggle('open');
        floatingInputincassi.classList.toggle('open');
        floatingDownloadPdfBtn.classList.toggle('open');
        floatingExcelBtn.classList.toggle('open');
    });
    document.querySelectorAll('a.page-link').forEach(link => {
        link.addEventListener('click', event => {
            event.preventDefault();
            let page = parseInt(event.target.dataset.n) - 1;
            $.post('post/component/incassi.php?pagination=' + page, parseFilter()).done(response => loadView(response));
        });
    });
    document.querySelector('#filter_cliente').querySelector('select#cliente').searchable();
    
}

document.addEventListener('DOMContentLoaded',function(){
    $.post('post/component/incassi.php?pagination=0', {} ).done(response => { loadView(response);});
});
