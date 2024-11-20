function _tab(element) {
    const page_component = document.querySelector('.page_component');
    $.post(element.getAttribute('target')).done(response => {
        while (page_component.firstChild) {
            page_component.removeChild(page_component.firstChild);
        }
        page_component.innerHTML = response;
    });
}
