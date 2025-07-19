window.modalHandlers = {};

function redirect(page){
    window.location.href = '/medplus/'+page;
}
function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}
function getCookie(name) {
    const nameEQ = name + "=";
    const cookiesArray = document.cookie.split(';');
    for(let i = 0; i < cookiesArray.length; i++) {
        let cookie = cookiesArray[i].trim();
        if (cookie.indexOf(nameEQ) === 0) {
            return cookie.substring(nameEQ.length, cookie.length);
        }
    }
    return null;
}
function eraseCookie(name) {   
    document.cookie = name + "=; Max-Age=-99999999; path=/";
}
function openModal(id) {
    var modal = new bootstrap.Modal(document.getElementById(id));
    modal.show();
}
function success_and_refresh() {
    sessionStorage.setItem('showSuccessToast', 'true');
    window.location.reload(true);
}
async function async_success_and_refresh(callbackName, callbackParams) {
    sessionStorage.setItem('showSuccessToast', 'true');
    sessionStorage.setItem('callbackToExecute', 'true');
    sessionStorage.setItem('callbackParams', JSON.stringify(callbackParams));
    sessionStorage.setItem('callbackName', callbackName);
    window.location.reload(true);
}
function success(){
    const toastLive = document.getElementById('successToast')
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLive);
    toastBootstrap.show();
}
function fail(){
    const toastLive = document.getElementById('failToast')
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLive);
    toastBootstrap.show();
}
function hoverIconWarning(element) {
    const row = element.closest('tr');
    row.classList.add('warning');
    element.addEventListener('mouseleave', function() {
        row.classList.remove('warning');
    });
};
function hoverIconAdd(element,toggle_class) {
    const row = element.closest('tr');
    row.classList.add(toggle_class);
    element.addEventListener('mouseleave', function() {
        row.classList.remove(toggle_class);
    });
};
function append_scripts(element){
    const scripts = element.querySelectorAll('script');
    scripts.forEach(script => {
        if (script.src) {
            const newScript = document.createElement('script');
            newScript.src = script.src;
            newScript.async = false;
            newScript.setAttribute('component',script.getAttribute('component'));
            if(script.type!=='')newScript.type=script.type;
            script.remove();
            element.appendChild(newScript);
        }
    });
}
function modal_component_no_spinner(id, component, _data, callback=false) {
    const modal_id = 'modal_' + component;
    _data['id_modal'] = modal_id;
    _data['component'] = component;
    $.post('modal_component.php', _data).done(html => {
        const container = document.querySelector('#' + id);
        document.querySelectorAll('#div_' + component).forEach(to_remove => { to_remove.remove(); });
        const div = document.createElement('div');
        div.id = 'div_' + component;
        div.innerHTML = html;
        append_scripts(div);
        container.appendChild(div);
        const modalElement = document.getElementById(modal_id);
        const newModalInstance = new bootstrap.Modal(modalElement, {keyboard: false});
        newModalInstance.show();
    });
}
function modal_component(id, component, _data) {
    const modal_id = 'modal_' + component;
    _data['id_modal'] = modal_id;
    _data['component'] = component;
    let container = document.querySelector('#' + id);
    if (!container) {
        container=document.createElement('div');
        container.id=id;
        document.body.appendChild(container);
    }
    document.querySelectorAll('#div_' + component).forEach(to_remove => to_remove.remove());
    const div = document.createElement('div');
    div.id = 'div_' + component;
    div.innerHTML = `<div class="modal-backdrop show"></div>`+spinner();
    container.appendChild(div);
    $.post('modal_component.php', _data).done(html => {
        div.innerHTML = html;
        append_scripts(div);
        const modalElement = document.getElementById(modal_id);
        const newModalInstance = new bootstrap.Modal(modalElement, {keyboard: false});
        newModalInstance.show();
    });
}
function spinner(){
    return `<div class="d-flex justify-content-center align-items-center" style="position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:1050;background:rgba(0,0,0,0.5);">
                <div class="spinner-border text-light" role="status"></div>
            </div>`;
}
function reload_modal_component(id, component,_data){
    closeAllModal();
    modal_component(id, component,_data);
    success();
}
function reload_modal_component_tree(params) {
    closeAllModal();
    params.forEach(param => {
        modal_component(param.id, param.component, param.data);
    });
}
function refresh(request){
    const params = new URLSearchParams(request);
    window.location.href = `${window.location.pathname}?${params.toString()}`
}
function resize(modal_id) {
    const modalDialog = document.querySelector(modal_id).querySelector('.modal-dialog');
    const btnResize = document.querySelector('.btn-resize');
    if (modalDialog.classList.contains('modal-fullscreen')) {
        modalDialog.classList.remove('modal-fullscreen');
        btnResize.style.setProperty('--bs-btn-resize-bg', 'var(--bs-btn-fullscreen-icon)');
        eraseCookie(modal_id+'_fullscreen');
    } else {
        modalDialog.classList.add('modal-fullscreen');
        btnResize.style.setProperty('--bs-btn-resize-bg', 'var(--bs-btn-resize-icon)');
        setCookie(modal_id+'_fullscreen');
    }
}
function closeModal(element) {
    const modalElement = element.closest('.modal');
    closeModalAndScripts(modalElement);
}
function closeAllModal() {
    document.querySelectorAll('.modal').forEach(modalElement => {
        closeModalAndScripts(modalElement);
    });
}
function closeModalAndScripts(modalElement) {
    if (modalElement) {
        const modal_id = modalElement.id;
        const component = modal_id.replace('modal_', '');
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        if (modalInstance) {
            modalInstance.hide();
            modalInstance.dispose();
        }
        modalElement.remove();
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
        if (window[modal_id] && typeof window[modal_id].cleanup === 'function') {
            window[modal_id].cleanup();
        }
        document.querySelectorAll(`script[component="${modal_id}"]`).forEach(modalScript => modalScript.remove());
        if (modalElement.modalHandlers) {
            delete modalElement.modalHandlers;
        }
        if (
            typeof window.modalHandlers !== 'undefined' &&
            typeof window.modalHandlers[component] !== 'undefined' &&
            typeof window.modalHandlers[component].deletePersistent !== 'undefined'
        ) {
            delete window.modalHandlers[window.modalHandlers[component].deletePersistent];
        }
        if (
            typeof window.modalHandlers !== 'undefined' &&
            typeof window.modalHandlers[component] !== 'undefined' &&
            typeof window.modalHandlers[component].persistent !== 'undefined'
        ) {
            delete window.modalHandlers[component];
        }
        document.querySelectorAll('#' + modalElement.id.replace('modal_','div_')).forEach(to_remove => { to_remove.remove(); });
    }
    if (!document.querySelector('.modal.show')) {
        document.body.classList.remove('modal-open');
    }
}
function component(component,_data){
    let element = document.querySelector('#'+component);
    _data['component']=component;
    $.post('component.php', _data)
        .done(response => {
            element.innerHTML = '';
            const content = document.createElement('div');
            content.innerHTML = response;
            element.appendChild(content);
            append_scripts(element);
        });
}
function search_table(_data){
    let element = document.querySelector('#search_table');
    _data['component']='search_table';
    $.post('post/search_table.php',_data).done(response=>{
        _data['response']=response;
        $.post('component.php', _data)
            .done(search_table => {
                element.innerHTML = '';
                const content = document.createElement('div');
                content.innerHTML = search_table;
                element.appendChild(content);
                append_scripts(element);
                $.post('component.php', {response:response,component:'search_table_body'})
                    .done(search_table_response => {
                        let search_table_body = element.querySelector('#search_table_body');
                        search_table_body.innerHTML = '';
                        search_table_body.innerHTML = search_table_response;
                        $.post('component.php', {response:response,component:'pagination'})
                            .done(pagination_response => {
                                let pagination = document.querySelector('#pagination');
                                pagination.innerHTML = '';
                                pagination.innerHTML = pagination_response;
                                document.addEventListener('click', function(event) {
                                    window.modalHandlers['search_table'].clickOutsideListener(event);
                                });
                            });
                    });
            });
    });

}
function excel(page,_data={}) {
    const div = document.createElement('div');
    div.id = 'div_excel_spinner';
    div.innerHTML=spinner();
    document.body.appendChild(div); 
    $.ajax({
        url: page,
        method: 'POST',
        data:_data,
        xhrFields: {
            responseType: 'blob'
        },
        success: function (data) {
            const url = window.URL.createObjectURL(data);
            const a = document.createElement('a');
            a.href = url;
            let filename = page.split("/").pop().split(".")[0];
            a.download = filename+'.xlsx';
            document.body.appendChild(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);
        },
        error: function () {
            fail();
        },
        complete:function(){
            div.remove();
        }
    });
}
function zip(page) {
    const div = document.createElement('div');
    div.id = 'div_zip_spinner';
    div.innerHTML = spinner();
    document.body.appendChild(div);

    $.ajax({
        url: page,
        method: 'POST',
        xhrFields: {
            responseType: 'arraybuffer'
        },
        success: function (data, status, xhr) {
            const blob = new Blob([data], { type: 'application/zip' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            let filename = page.split("/").pop().split(".")[0];
            a.download = filename + '.zip';
            document.body.appendChild(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);
        },
        error: function () {
            fail();
        },
        complete: function () {
            div.remove();
        }
    });
}
function pdf(component,sid) {
    const div = document.createElement('div');
    div.id = 'div_pdf_spinner';
    div.innerHTML = spinner();
    document.body.appendChild(div);

    $.post('pdf_render.php', { component:component, sid:sid }).done((path) => {
        div.remove();
        const a = document.createElement('a');
        a.href = path;
        a.download = 'document.pdf';
        document.body.appendChild(a);
        a.click();
        a.remove();
    });
}
document.addEventListener('DOMContentLoaded', () => {
    if (sessionStorage.getItem('showSuccessToast') === 'true') {
        const toastLive = document.getElementById('successToast');
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLive);
        toastBootstrap.show();
        sessionStorage.removeItem('showSuccessToast');
    }
    if (sessionStorage.getItem('callbackToExecute') === 'true') {
        sessionStorage.removeItem('callbackToExecute');
        const callbackName = sessionStorage.getItem('callbackName');
        if (callbackName) {
            const callbackParams = JSON.parse(sessionStorage.getItem('callbackParams'));
            sessionStorage.removeItem('callbackName');
            sessionStorage.removeItem('callbackParams');
        }
    }
});