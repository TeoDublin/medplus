function parseFilter(){
    let ret = {};
    let alerts = [];
    let data_seduta_da = document.querySelector('#data_seduta_da').value;
    let data_seduta_a = document.querySelector('#data_seduta_a').value;
    let data_seduta_all = document.querySelector('#data_seduta_all').checked;
    let id_terapista = document.querySelector('#id_terapista').value;
    let stato_seduta = document.querySelector('#stato_seduta').value;
    let stato_pagamento = document.querySelector('#stato_pagamento').value;

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
    if(id_terapista!==''){
        ret.id_terapista = id_terapista;
        ret.terapista=document.querySelector('#id_terapista').selectedOptions[0].text;
    }
    if(stato_seduta!=='')ret.stato_seduta=stato_seduta;

    if(stato_pagamento!=='')ret.stato_pagamento=stato_pagamento;

    if(alert.length>0){
        alert(alerts.join('\n'));       
    }
    return ret;
}
function btnFiltra() {
    $.post('post/component/sedute.php?pagination=0', parseFilter())
    .done(response => { loadView(response);});
}
function btnClean(){
    $.post('post/component/sedute.php?pagination=0', {'btnClean':true} ).done(response => { loadView(response);});
}
function loadView(response){
    document.querySelector('#spa_sedute').innerHTML = response;
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
            let page = parseInt(event.target.innerHTML) - 1;
            $.post('post/component/sedute.php?pagination=' + page, parseFilter()).done(response => loadView(response));
        });
    });
    
}
document.addEventListener('DOMContentLoaded',function(){
    $.post('post/component/sedute.php?pagination=0', {} ).done(response => { loadView(response);});
});
