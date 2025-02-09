function login() {
    const username = document.querySelector('#user').value;
    const password = document.querySelector('#password').value;

    if (!username || !password) {
        alert("Inserisci username e password");
        return;
    }
    else{
        fetch('post/login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ username, password })
        })
        .then(response => response.json())
        .then(data => {
            switch (data.response) {
                case 'wrong_user':
                    wrong_user();
                    break;
                case 'wrong_pass':
                    wrong_pass();
                    break;
                case 'success':
                    success();
                    redirect(data.home);
                    break;
            }
        })
        .catch(() => {
            console.error("Errore di connessione");
        });
    }
}
function wrong_user(){
    const toastLive = document.getElementById('wrong_user')
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLive);
    toastBootstrap.show();
}
function wrong_pass(){
    const toastLive = document.getElementById('wrong_pass')
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLive);
    toastBootstrap.show();
}
function success(){
    const toastLive = document.getElementById('success')
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLive);
    toastBootstrap.show();
}

document.addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        login();
    }
});