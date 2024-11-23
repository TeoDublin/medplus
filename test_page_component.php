<?php 
require 'includes.php';
require 'includes/header.php';
$component=$_REQUEST['component'];
$tab=$_REQUEST['tab'];
require_once "page_components/{$component}/ctrl.php";
require_once "page_components/{$component}/view.php";

require 'includes/footer.php';