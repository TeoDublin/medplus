<?php
global $session,$elementi; 
$session = Session();
if (!$session->isLoggedIn()) {
    redirect('login.php');
}
else $elementi=$session->get('elementi');