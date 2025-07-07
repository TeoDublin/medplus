<?php 
    function _tab($tab):bool{
        return cookie('tab','elenco')==$tab;
    }
    $session=Session();
    $elementi=$session->get('elementi')??[];