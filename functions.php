<?php
    function root_path(string $path): string {
        return "/medplus/{$path}";
    }
    function url(string $path): string {
        $rootUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
        return $rootUrl.root_path("{$path}");
    }
    function image(string $name): string {
        return root_path("assets/images/{$name}");
    }
    function icon(string $name): string {
        return root_path("assets/icons/{$name}");
    }
    function root(string $path):string{
        return $_SERVER['DOCUMENT_ROOT'].root_path($path);
    }
    function environment():string{
        return 'dev';
    }
    function theme():string{
        return Session()->get('template')->theme ?? 'blue';
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
        header("Location: {$page}". (str_ends_with($page,'.php')?'':'.php'));
        exit();
    }
    function component(string $name, array $params=[]):void{
        include root("components/{$name}.php");
    }