<?php 
    $tab=cookie('tab','registrate'); 
    
    function _tab($tab):bool{
        return cookie('tab','registrate')==$tab;
    }
    