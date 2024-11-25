<?php 
$_REQUEST['test']=true;
$_REQUEST['skip_cookie']=true;
require 'includes.php';
require 'includes/header.php';
$component=$_REQUEST['component'];
$tab=$_REQUEST['tab'];
require_once "page_components/{$component}/ctrl.php";
require 'includes/header.php';
echo "<div class=\"page-content\"></div>";
require_once "page_components/{$component}/view.php";
require 'includes/footer.php';