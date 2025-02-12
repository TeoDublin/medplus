<?php
global $session,$elementi; 
$session = Session();
if (!$session->isLoggedIn()||!$session->get('home')) {
    redirect('login.php');
}
else $elementi=$session->get('elementi');