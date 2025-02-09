<?php 
$_REQUEST['skip_cookie']=true;
require_once 'includes.php';
require_once 'includes/header.php';
$component=$_REQUEST['component'];?>
<div class="p-2" id="modal_id"></div><?php
require_once 'includes/footer.php';?>
<script>
    document.addEventListener('DOMContentLoaded',modal_component('modal_id',<?php echo "'{$component}',". json_encode($_REQUEST);?>));
</script>