<?php 
    function _tab($tab):bool{
        return cookie('tab','planning')==$tab;
    }