function _tab(element) {
    const page_component = document.querySelector('.page_component');
    document.querySelectorAll('.active').forEach(active=>{ active.classList.remove('active');});
    $.post(element.getAttribute('target'),{skip_cookie:true,component:"customer-picker"}).done(response => {
        while (page_component.firstChild) {
            page_component.removeChild(page_component.firstChild);
        }
        page_component.innerHTML = response;
        append_scripts(page_component);
        element.classList.add('active');
    });
}
