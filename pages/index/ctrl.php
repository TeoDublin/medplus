<?php
    if(is_submit()){
        $user=users()->first(['u_user'=>$_POST['user'],'u_pasword'=>$_POST['password']]);
        if(count($user)> 0){
            Session()->start($user);
            redirect('home');
        }
        else Session()->delete('is_loged');

    }
    elseif(was_logged()){
        $user=users()->first(['u_id'=>Session()->get('user_id')]);
        Session()->start($user);
        redirect('home');
    }
