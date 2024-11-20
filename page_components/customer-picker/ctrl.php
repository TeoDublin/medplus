<?php
    function _tab($tab):bool{
        return ($_REQUEST['tab']??'anagrafica')==$tab;
    }