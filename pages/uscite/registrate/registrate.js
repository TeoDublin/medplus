function parseFilter(){
    let ret = {};
    let alerts = [];
    let data_pagamento_da = document.querySelector('#data_pagamento_da').value;
    let data_pagamento_a = document.querySelector('#data_pagamento_a').value;
    let data_pagamento_all = document.querySelector('#data_pagamento_all').checked;
    let id_uscita = document.querySelector('#indirizzato_a').value;
    let indirizzato_a= document.querySelector('#indirizzato_a option:checked').innerHTML;

    if(data_pagamento_da !== '' && data_pagamento_a !== ''){
        if(data_pagamento_a<data_pagamento_da){
            alerts.push("data_pagamento fine non puo essere inferiore alla data_pagamento Inizio");
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
    if(id_uscita!=='')ret.id_uscita=id_uscita;
    if(indirizzato_a!==''&&indirizzato_a!=='Tutti')ret.indirizzato_a=indirizzato_a;

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
            let page = parseInt(event.target.data_pagamentoset.n) - 1;
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
        $.post('post/uscite_delete.php',{table:'uscite_registrate',id:id}).done(()=>{success_and_refresh();}).fail(()=>{fail();})
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
