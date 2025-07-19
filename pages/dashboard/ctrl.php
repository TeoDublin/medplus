<?php 
    function _tab($tab):bool{
        return cookie('tab','kpis')==$tab;
    }