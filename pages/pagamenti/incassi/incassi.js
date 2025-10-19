function parseFilter(){
    return {};
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
function inputExcel(){
    modal_component('input_excel_incassi','input_excel_incassi',{});
}
document.addEventListener('DOMContentLoaded',function(){
    $.post('post/component/incassi.php?pagination=0', {} ).done(response => { loadView(response);});
});
