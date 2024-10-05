<?php
    function root_path($path): string {
        return "/medplus/{$path}";
    }
    function root($path):string{
        return $_SERVER['DOCUMENT_ROOT'].root_path($path);
    }
    function environment():string{
        return 'dev';
    }
    function is_submit():bool{
        return !empty($_POST)&&isset($_POST['submit']);
    }
    function was_logged():bool{
        return Session()->get('is_logged') ?? false;
    }
    function is_logged():bool{
        return !empty($_SESSION)&&Session()->get('is_logged');
    }
    function redirect(string $page):void{
        header("Location: {$page}.php");
        exit();
    }
    function component(string $name, array $params=[]):void{
        include root("components/{$name}.php");
    }