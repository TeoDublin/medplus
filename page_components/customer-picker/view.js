function _tab(element) {
    const modal = element.closest('.modal');
    const page_component = modal.querySelector('.page_component');
    modal.querySelectorAll('.active').forEach(active=>{ active.classList.remove('active');});
    $.post(element.getAttribute('target'),{skip_cookie:true,component:"customer-picker"}).done(response => {
        while (page_component.firstChild) {
            page_component.removeChild(page_component.firstChild);
        }
        page_component.innerHTML = response;
        append_scripts(modal);
        element.classList.add('active');
    });
    if(element.getAttribute('tab')=='anagrafica'){
        modal.querySelector('.modal-footer').removeAttribute('hidden');
    }
    else{
        modal.querySelector('.modal-footer').setAttribute('hidden','');
    }
}
