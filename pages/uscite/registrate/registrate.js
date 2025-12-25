function parseFilter(){
    let ret = {'unset':'btnClean'};
    let alerts = [];
    let data_pagamento_da = document.querySelector('#data_pagamento_da').value;
    let data_pagamento_a = document.querySelector('#data_pagamento_a').value;
    let data_pagamento_all = document.querySelector('#data_pagamento_all').checked;

    if(data_pagamento_da !== '' && data_pagamento_a !== ''){
        if(data_pagamento_a<data_pagamento_da){
            alerts.push("data_pagamento fine non puo essere inferiore alla data_pagamento Inizio");
        }
    }

    if (data_pagamento_da !== '' || data_pagamento_a !== '' || data_pagamento_all ==true ) {
        ret.data_pagamento = {};
        if (data_pagamento_all == true){
            ret.data_pagamento.all = data_pagamento_all;
        }
        else{
            if (data_pagamento_da !== ''){
                ret.data_pagamento.da = data_pagamento_da;
            }
            if (data_pagamento_a !== ''){
                ret.data_pagamento.a = data_pagamento_a;
            }
        }
    }

    let id_categoria = $('#id_categoria').val() || [];
    if (id_categoria.length > 0) {
        ret.id_categoria = id_categoria;
    }

    let id_uscita = $('#id_uscita').val() || [];
    if (id_uscita.length > 0) {
        ret.id_uscita = id_uscita;
    }

    let id_indirizzato_a = $('#id_indirizzato_a').val() || [];
    if (id_indirizzato_a.length > 0) {
        ret.id_indirizzato_a = id_indirizzato_a;
    }

    let in_capo_a = $('#in_capo_a').val() || [];
    if (in_capo_a.length > 0) {
        ret.in_capo_a = in_capo_a;
    }

    let tipo_pagamento = $('#tipo_pagamento').val() || [];
    if (tipo_pagamento.length > 0) {
        ret.tipo_pagamento = tipo_pagamento;
    }

    let voucher = $('#voucher').val() || [];
    if (voucher.length > 0) {
        ret.voucher = voucher;
    }

    let note = $('#note').val() || '';
    if (note !== '') {
        ret.note = note;
    }

    if(alert.length>0){
        alert(alerts.join('\n'));       
    }

    return ret;
}

function btnFiltra() {
    $.post('pages/uscite/registrate/post_component/registrate.php?pagination=0', parseFilter())
    .done(response => { loadView(response);});
}

function btnClean(){
    $.post('pages/uscite/registrate/post_component/registrate.php?pagination=0', {'btnClean':true, 'cookie':{'btnClean':1}} ).done(response => { loadView(response);});
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
            $.post('pages/uscite/registrate/post_component/registrate.php?pagination=' + page, parseFilter()).done(response => loadView(response));
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
    $.post('pages/uscite/registrate/post_component/registrate.php?', {} ).done(response => { loadView(response);});
});
