<?php 
    function _tab($tab):bool{
        return cookie('tab','da_fatturare')==$tab;
    }