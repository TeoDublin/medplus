<?php 
require_once 'includes.php';
require_once 'includes/session.php';
redirect($session->get('home'));