function parseFilter(){
    let ret = {};
    let alerts = [];
    let data_da = document.querySelector('#data_da').value;
    let data_a = document.querySelector('#data_a').value;
    let data_all = document.querySelector('#data_all').checked;
    let id_uscita = document.querySelector('#nome').value;
    let nome= document.querySelector('#nome option:checked').innerHTML;

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
    if(id_uscita!=='')ret.id_uscita=id_uscita;
    if(nome!==''&&nome!=='Tutti')ret.nome=nome;

    if(alert.length>0){
        alert(alerts.join('\n'));       
    }
    return ret;
}

function btnFiltra() {
    $.post('post/component/uscite_registrate.php?pagination=0', parseFilter())
    .done(response => { loadView(response);});
}

function btnClean(){
    $.post('post/component/uscite_registrate.php?pagination=0', {'btnClean':true} ).done(response => { loadView(response);});
}

function loadView(response){
    document.querySelector('#spa_registrate').innerHTML = response;
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
            $.post('post/component/uscite_registrate.php?pagination=' + page, parseFilter()).done(response => loadView(response));
        });
    });
}
function aggiungiUscita(){
    modal_component('add_uscita','add_uscita',{});
}
function enterDel(e){
    e.closest('tr').classList.add('bg-danger');
}
function leaveDel(e){
    e.closest('tr').classList.remove('bg-danger');
}
function delClick(id){
    if(confirm('Sicuro di voler eliminare?')){
        $.post('post/delete.php',{table:'uscite_per_giorno',id:id}).done(()=>{success_and_refresh();}).fail(()=>{fail();})
    }
}
function enterEdit(e){
    e.closest('tr').classList.add('bg-success');
}
function leaveEdit(e){
    e.closest('tr').classList.remove('bg-success');
}
function clickEdit(id){
    modal_component('add_uscita','add_uscita',{id:id});
}
document.addEventListener('DOMContentLoaded',function(){
    $.post('post/component/uscite_registrate.php?pagination=0', {} ).done(response => { loadView(response);});
});
