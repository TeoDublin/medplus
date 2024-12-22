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
document.addEventListener('DOMContentLoaded', () => {
    if (sessionStorage.getItem('showSuccessToast') === 'true') {
        const toastLiveExample = document.getElementById('successToast');
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
        toastBootstrap.show();
        sessionStorage.removeItem('showSuccessToast');
    }
    if (sessionStorage.getItem('callbackToExecute') === 'true') {
        sessionStorage.removeItem('callbackToExecute');
        const callbackName = sessionStorage.getItem('callbackName');
        if (callbackName) {
            const callbackParams = JSON.parse(sessionStorage.getItem('callbackParams'));
            if (callbackName === 'page_component' && callbackParams) {
                console.log(callbackParams);
                page_component(callbackParams.id, callbackParams.component, callbackParams._data);
            }
            sessionStorage.removeItem('callbackName');
            sessionStorage.removeItem('callbackParams');
        }
    }
});
function success(){
    const toastLiveExample = document.getElementById('successToast')
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
    toastBootstrap.show();
}
function fail(){
    const toastLiveExample = document.getElementById('failToast')
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
    toastBootstrap.show();
}
function hoverIconWarning(element) {
    const row = element.closest('tr');
    row.classList.add('warning');
    element.addEventListener('mouseleave', function() {
        row.classList.remove('warning');
    });
};
function hoverIconAdd(element) {
    const row = element.closest('tr');
    row.classList.add('success');
    element.addEventListener('mouseleave', function() {
        row.classList.remove('success');
    });
};
function append_scripts(element){
    const scripts = element.querySelectorAll('script');
    scripts.forEach(script => {
        if (script.src) {
            const newScript = document.createElement('script');
            newScript.src = script.src;
            newScript.async = false;
            document.body.appendChild(newScript);
        }
    });
}
function modal_component(id, component,_data) {
    const modal_id = 'modal_'+id;
    _data['id_modal']=modal_id;_data['component']=component;
    $.post('modal_component.php',_data).done(html=>{
        const container = document.querySelector('#'+id);
        document.querySelectorAll('#div_'+id).forEach(function(to_remove){ to_remove.remove();});
        const div = document.createElement('div');
        div.id = 'div_'+id;
        div.innerHTML = html;
        append_scripts(div);
        container.appendChild(div);
        const modalElement = document.getElementById(modal_id);
        const newModalInstance = new bootstrap.Modal(modalElement, {});
        modalElement.modalInstance = newModalInstance;
        const modalCookie=getCookie('#'+modal_id+'_fullscreen');
        if(modalCookie!==null){
            resize('#'+modal_id);
        }
        newModalInstance.show();
    });
}
function page_component(id, component,_data) {
    const modal_id = 'modal_'+id;
    _data['skip_cookie']=true;_data['id_modal']=modal_id;_data['component']=component;
    $.post('page_component.php',_data).done(html=>{
        const container = document.querySelector('#'+id);
        document.querySelectorAll('#div_'+id).forEach(function(to_remove){ to_remove.remove();});
        const div = document.createElement('div');
        div.id = 'div_'+id;
        div.innerHTML = html;
        append_scripts(div);
        container.appendChild(div);
        const modalElement = document.getElementById(modal_id);
        const newModalInstance = new bootstrap.Modal(modalElement, {});
        modalElement.modalInstance = newModalInstance;
        const modalCookie=getCookie('#'+modal_id+'_fullscreen');
        if(modalCookie!==null){
            resize('#'+modal_id);
        }
        newModalInstance.show();
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
    if (modalElement) {
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        if (modalInstance) {
            modalInstance.hide();
        } else {
            console.warn('No Bootstrap instance found for this modal.');
        }
    }
}
function closeAllModal() {
    document.querySelectorAll('.modal').forEach(modalElement => {
        if (modalElement) {
            modalElement.classList.remove('show');
            modalElement.style.display = 'none';
            modalElement.removeAttribute('aria-hidden');
            modalElement.removeAttribute('aria-modal');
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
            modalElement.remove();
        }
    });
}
