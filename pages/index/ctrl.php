<?php
    if(is_submit()){
        $user=Utenti()->first(['utente'=>$_POST['user'],'pasword'=>$_POST['password']]);
        if(count($user)> 0){
            Session()->start($user);
            redirect('home');
        }
        else Session()->delete('is_loged');

    }
    elseif(was_logged()){
        $user=Utenti()->first(['id'=>Session()->get('user_id')]);
        Session()->start($user);
        redirect('home');
    }
