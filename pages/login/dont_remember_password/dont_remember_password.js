function send_current(){
    const user = document.querySelector('#user').value;
    $.post('post/dont_remember_password.php',{'user':user}).done((response)=>{
        if(response.trim() === 'mail_sent'){
            alert('Email inviata con successo, controlla la tua casella');
        } 
        else if(response.trim() === 'error_sending'){
            alert('Errore nell\'invio dell\'email, riprova più tardi');
        } 
        else if(response.trim() === 'not_found'){
            alert('Utente non trovato');
        }
        console.log(response);
    }).fail(()=>{fail();});
}