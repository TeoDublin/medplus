<?php 
    function _tab($tab):bool{
        return cookie('tab','anagrafica')==$tab;
    }