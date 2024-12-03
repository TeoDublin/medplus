<?php 
    $result=$_REQUEST['id']?Select('*')->from('clienti','c')->where("c.id={$_REQUEST['id']}")->first_or_false():false;
    require_once 'page_components/customer-picker/anagrafica/anagrafica.php';
    script('components/clienti/clienti.js');