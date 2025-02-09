<?php 
require_once 'includes.php';
require_once 'includes/header.php';
$component=$_REQUEST['component'];
component($component,'php');
component($component,'css');
component($component,'js');
require_once 'includes/footer.php';