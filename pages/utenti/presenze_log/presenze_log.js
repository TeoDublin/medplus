function parseFilter(){
    let ret = {'unset':'btnClean'};
    let alerts = [];
    let data_da = document.querySelector('#data_da').value;
    let data_a = document.querySelector('#data_a').value;
    let data_all = document.querySelector('#data_all').checked;
    let id_utenti = document.querySelector('#id_utenti').value;
    
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
    if(id_utenti!==''){
        ret.id_utenti = id_utenti;
        ret.username=document.querySelector('#id_utenti').selectedOptions[0].text;
    }

    if(alert.length>0){
        alert(alerts.join('\n'));       
    }
    return ret;
}
function btnFiltra() {
    $.post('pages/utenti/presenze_log/post/presenze_log.php?pagination=0', parseFilter())
    .done(response => { loadView(response);});
}
function btnClean(){
    $.post('pages/utenti/presenze_log/post/presenze_log.php?pagination=0', {'btnClean':true, 'cookie':{'btnClean':1}} ).done(response => { loadView(response);});
}
function loadView(response){
    document.querySelector('#spa_presenze_log').innerHTML = response;
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
            $.post('pages/utenti/presenze_log/post/presenze_log.php?pagination=' + page, parseFilter()).done(response => loadView(response));
        });
    });
    
}
function editEnter(e){
    e.closest('tr').classList.add('hover');
}
function editLeave(e){
    e.closest('tr').classList.remove('hover');
}
function edit(id){
    modal_component('presenze_log','presenze_log',{id:id});
}
function del(id){
    if(confirm('Sicuro di voler eliminare ?')){
        $.post('post/delete.php',{table:'utenti_presenze',id:id}).done(()=>{success_and_refresh();}).fail(fail());
    }
}
document.addEventListener('DOMContentLoaded',function(){
    $.post('pages/utenti/presenze_log/post/presenze_log.php?pagination=0', {} ).done(response => { loadView(response);});
});
