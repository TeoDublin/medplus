<?php 
    function _tab($tab):bool{
        return cookie('tab','fattura_libera')==$tab;
    }