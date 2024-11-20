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
    window.location.href = window.location.href;
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

function append_scripts(modalElement){
    const scripts = modalElement.querySelectorAll('script');
    scripts.forEach(script => {
        if (script.src) {
            const newScript = document.createElement('script');
            newScript.src = script.src;
            newScript.async = false;
            document.body.appendChild(newScript);
        }
    });
}