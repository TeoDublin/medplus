<?php
    require 'includes.php';
    require 'header.php';
    echo "test2";
    var_dump(users()->first(['u_id'=>1]));
    var_dump(error_get_last());
    require 'footer.php';