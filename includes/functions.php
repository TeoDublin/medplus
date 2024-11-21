<?php
    function request($key){
        $ret=$_REQUEST[$key];
        unset($_REQUEST[$key]);
        return $ret;
    }
    function environment():string{
        return 'dev';
    }
    function page():string{
        $split= explode('/',strtok($_SERVER['REQUEST_URI']??$_SERVER['HTTP_REFERER'], '?'));
        return str_replace('.php','',end($split));
    }
    function root_path(string $path): string {
        return "/".PROJECT_NAME."/{$path}";
    }
    function url(string $path): string {
        $rootUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
        return $rootUrl.root_path("{$path}");
    }
    function image(string $name): string {
        return root_path("assets/images/{$name}");
    }
    function icon(string $name,string $color='black',string $width='16',string $height='16'): string {
        $svg = file_get_contents(root("assets/icons/{$name}"));
        $svg = str_replace('width="16"', 'width="'.$width.'"', $svg);
        $svg = str_replace('height="16"', 'height="'.$height.'"', $svg);
        $svg = str_replace('fill="black"', 'fill="'.$color.'"', $svg);
        return $svg;
    }
    function component(string $name, string $extention): void {
        global $result;
        if(file_exists("components/{$name}/{$name}.{$extention}")){
            switch ($extention) {
                case 'js':
                    echo '<script src="'.root_path("components/{$name}/{$name}.{$extention}").'?v='.filemtime(root("components/{$name}/{$name}.{$extention}")).'"></script>';
                    break;
                case 'css':
                    echo '<link rel="stylesheet" href="'.root_path("components/{$name}/{$name}.{$extention}").'?v='.filemtime(root("components/{$name}/{$name}.{$extention}")).'">';
                    break;
                default:
                    require root("components/{$name}/{$name}.{$extention}");
                    break;
            }
        }
    }
    function component_page(string $name,string $tab,string $extention): void {
        global $result;
        if(file_exists("components/{$name}/{$name}.{$extention}")){
            switch ($extention) {
                case 'js':
                    echo '<script src="'.root_path("components/{$name}/{$tab}/{$tab}.{$extention}").'?v='.filemtime(root("components/{$name}/{$name}.{$extention}")).'"></script>';
                    break;
                case 'css':
                    echo '<link rel="stylesheet" href="'.root_path("components/{$name}/{$tab}/{$tab}.{$extention}").'?v='.filemtime(root("components/{$name}/{$name}.{$extention}")).'">';
                    break;
                default:
                    require root("components/{$name}/{$tab}/{$tab}.{$extention}");
                    break;
            }
        }
    }
    function style(String $full_path):void{
        echo '<link rel="stylesheet" href='.$full_path.'?v='.filemtime(root($full_path)).'">';
    }
    function script(String $full_path):void{
        echo '<script src="'.$full_path.'?v='.filemtime($full_path).'"></script>';
    }
    function root(string $path):string{
        return $_SERVER['DOCUMENT_ROOT'].root_path($path);
    }
    function theme():string{
        return Session()->get('template')->theme ?? 'blue';
    }
    function is_submit():bool{
        $ret=!empty($_POST)&&isset($_POST['submit']);
        return $ret;
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
    function clean_post():array{
        $ret=array_diff_key($_POST,['submit'=>true,'action'=>true]);
        $_POST=[];
        return $ret;
    }
    function now(string $format):string{
        return date($format);
    }
    function datetime() {
        return date('Y-m-d H:i:s');
    }
    function format_date(string $date):string{
        $split=explode('/',$date);
        return "{$split[2]}-{$split[1]}-{$split[0]}";
    }
    function str_scape(string $text):string{
        return str_replace("'","\'",$text);
    }