<?php 
require 'includes.php';
require 'includes/header.php';
component('calendar',['id'=>'test','container-class'=>'start-0 top-0','toggleElement'=>'.test']);
component('calendar',['id'=>'test2','container-class'=>'start-50 top-0','toggleElement'=>'.test']);
require 'includes/footer.php';