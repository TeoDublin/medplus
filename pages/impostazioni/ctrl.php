<?php 
    function _tab($tab):bool{
        return cookie('tab','trattamenti')==$tab;
    }