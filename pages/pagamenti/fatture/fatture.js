function parseFilter(){
    let ret = {};
    let alerts = [];
    let data_da = document.querySelector('#data_da').value;
    let data_a = document.querySelector('#data_a').value;
    let data_all = document.querySelector('#data_all').checked;
    let fatturato_da = document.querySelector('#fatturato_da').value;
    let stato = document.querySelector('#stato').value;
    let confermato_dal_commercialista = document.querySelector('#confermato_dal_commercialista').value;

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
    if(fatturato_da!=='')ret.fatturato_da=fatturato_da;
    if(stato!=='')ret.stato=stato;
    if(confermato_dal_commercialista!=='')ret.confermato_dal_commercialista=confermato_dal_commercialista;
    if(alert.length>0){
        alert(alerts.join('\n'));       
    }
    return ret;
}
function btnFiltra() {
    $.post('post/component/fatture.php?pagination=0', parseFilter())
    .done(response => { loadView(response);});
}
function btnClean(){
    $.post('post/component/fatture.php?pagination=0', {'btnClean':true} ).done(response => { loadView(response);});
}
function loadView(response){
    document.querySelector('#spa_fatture').innerHTML = response;
    const floatingMenu = document.querySelector('.floating-menu');
    const floatingMenuBtn = document.querySelector('.floating-menu-btn');
    const floatingExcelBtn = document.querySelector('.floating-excel-btn');
    const floatingDownloadBtn = document.querySelector('.floating-download-fatture-btn');
    floatingMenuBtn.addEventListener('click', () => {
        floatingMenu.classList.toggle('open');
        floatingMenuBtn.classList.toggle('open');
        floatingExcelBtn.classList.toggle('open');
        floatingDownloadBtn.classList.toggle('open');
    });
    document.querySelectorAll('a.page-link').forEach(link => {
        link.addEventListener('click', event => {
            event.preventDefault();
            let page = parseInt(event.target.innerHTML) - 1;
            $.post('post/component/fatture.php?pagination=' + page, parseFilter()).done(response => loadView(response));
        });
    });
    
}
document.addEventListener('DOMContentLoaded',function(){
    $.post('post/component/fatture.php?pagination=0', {} ).done(response => { loadView(response);});
});
