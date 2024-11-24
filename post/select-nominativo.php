<?php 
    require '../includes.php';
    unset($_REQUEST['skip_cookie']);
    echo Select('*')->from('clienti')->where("nominativo like '%".str_replace("'","\'",$_POST['nominativo'])."%'")->json();