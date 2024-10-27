<?php 
require 'includes.php';
require 'includes/header.php';?>

<button class="datepicker m-5">test</button>
<input class="planning-date"/>
<?php
component('calendar','css');
component('calendar','php');
component('calendar','js');?>
<script>calendar.start('.datepicker', '.planning-date');</script><?php
require 'includes/footer.php';