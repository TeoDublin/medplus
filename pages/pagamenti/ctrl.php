<?php 
    function _tab($tab):bool{
        return cookie('tab','sedute')==$tab;
    }