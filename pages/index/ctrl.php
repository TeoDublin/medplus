<?php
    if(is_submit()){
        $user=users()->first(['user'=>$_POST['user'],'pasword'=>$_POST['password']]);
        if(count($user)> 0){
            Session()->start($user);
            redirect('home');
        }
        else Session()->delete('is_loged');

    }
    elseif(was_logged()){
        $user=users()->first(['id'=>Session()->get('user_id')]);
        Session()->start($user);
        redirect('home');
    }
