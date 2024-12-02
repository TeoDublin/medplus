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

document.addEventListener('DOMContentLoaded', () => {
    if (sessionStorage.getItem('showSuccessToast') === 'true') {
        const toastLiveExample = document.getElementById('successToast');
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
        toastBootstrap.show();
        sessionStorage.removeItem('showSuccessToast');
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
function new_modal(id, component,_data) {
    const modal_id = 'modal_'+id;
    _data['skip_cookie']=true;_data['id']=modal_id;_data['component']=component;
    $.post('modal_component.php',_data).done(function(html){
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
        newModalInstance.show();
    });
}

function new_page_modal(id, component,_data) {
    const modal_id = 'modal_'+id;
    _data['skip_cookie']=true;_data['id']=modal_id;_data['component']=component;
    $.post('page_component.php',_data).done(function(html){
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
        newModalInstance.show();
    });
}
