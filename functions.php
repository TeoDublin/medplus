<?php
    function environment():string{
        return 'prod';
    }
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
    function icon(string $name,string $color='black',int $width=16,int $height=16): string {
        $svg = file_get_contents(root("assets/icons/{$name}"));
        $svg = str_replace('width="16"', 'width="'.$width.'"', $svg);
        $svg = str_replace('height="16"', 'height="'.$height.'"', $svg);
        $svg = str_replace('fill="black"', 'fill="'.$color.'"', $svg);
        return $svg;
    }
    function root(string $path):string{
        return $_SERVER['DOCUMENT_ROOT'].root_path($path);
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