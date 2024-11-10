<?php 
require 'includes.php';
require 'includes/header.php';
$component=cookie('component','');
component($component,'php');
component($component,'css');
component($component,'js');
require 'includes/footer.php';