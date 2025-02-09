<?php
global $session; 
$session = Session::getInstance();
if (!$session->isLoggedIn()) {
    redirect('login.php');
}