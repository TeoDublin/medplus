<?php 
    echo json_encode(Select($_POST['select'])->from($_POST['table'])->first());