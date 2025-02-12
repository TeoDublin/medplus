const floatingMenu = document.querySelector('.floating-menu');
const floatingMenuBtn = document.querySelector('.floating-menu-btn');

floatingMenuBtn.addEventListener('click', () => {
    floatingMenu.classList.toggle('open');
    floatingMenuBtn.classList.toggle('open');
});

function btnFiltra(){
    const id_cliente = document.querySelector('#id_cliente').value;
    const origine = document.querySelector('#origine').value;
    let url = "pagamenti.php?skip_cookie=true&pagination=0&";
    if(id_cliente!=null && id_cliente!="")url+='id_cliente='+id_cliente+'&';
    if(origine!=null && origine!="")url+='origine='+origine+'&';
    window.document.location = url;
}

function btnClean(){
    window.document.location = 'pagamenti.php?pagination=0';
}