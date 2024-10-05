<?php
    require 'includes.php';
    require 'header.php';
    var_dump(users()->first(['where'=>1]));
    require 'footer.php';