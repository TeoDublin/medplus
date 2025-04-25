<?php
$_REQUEST['skip_cookie'] = true;
$component = $_REQUEST['component'];
require_once 'includes.php';
require_once 'includes/session.php';
require_once 'includes/header.php';
require_once "pdf_component/{$component}/{$component}.php";
require_once 'includes/footer.php';