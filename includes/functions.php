<?php
    function request($key,$fallback=false){
        $ret=$_REQUEST[$key]??false;
        unset($_REQUEST[$key]);
        return $ret ?? $fallback;
    }
    function parse_where($where):string{
        return implode(' AND ', array_map(
            fn($key, $value) => is_numeric($value) ? "$key=$value" : "$key='$value'",
            array_keys($where),
            $where
        ));        
    }
    function italian_date($date,$format){
        putenv('LC_TIME=it_IT.UTF-8');
        setlocale(LC_TIME, 'it_IT.UTF-8');
        $formattedDate = strftime($format, strtotime($date));
        return ucfirst($formattedDate);
    }
    function environment():string{
        return $_SERVER['HTTP_HOST']=='127.0.0.1:8080'?'dev':'prod';
    }
    function page():string{
        $url=$_SERVER['REQUEST_URI']??$_SERVER['HTTP_REFERER'];
        $exceptions=[
            'post/search_table',
            'component',
            'modal_component'
        ];
        foreach ($exceptions as $exception) {
            if($url=="/".PROJECT_NAME.'/'.$exception.'.php'){
                $url=str_replace($_SERVER['HTTP_ORIGIN'],'',$_SERVER['HTTP_REFERER']);
                break;
            }
        }
        $split= explode('/',strtok($url, '?'));
        $ret=str_replace('.php','',end($split));
        if(isset($_REQUEST['search']))$ret.='_searching';
        return $ret;
    }
    function root_path(string $path): string {
        return "/".PROJECT_NAME."/{$path}";
    }
    function privacy_path(string $path):string{
        return dirname(__DIR__) . "/".PRIVACY_FOLDER."/".$path;
    }
    function privacy_url(string $path):string{
        return url(PRIVACY_FOLDER."/".$path);
    }
    function fatture_path(string $filename):string{
        return FATTURE_FOLDER.'/'.$filename;
    }
    function url(string $path): string {
        $rootUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
        return $rootUrl.root_path("{$path}");
    }
    function url_no_port(string $path): string {
        $host = explode(':', $_SERVER['HTTP_HOST'])[0];
        $rootUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $host;
        return $rootUrl . root_path("{$path}");
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
    function component(string $name, string $extention='all'): void {
        global $result;
        if($extention=='all'){
            component($name, 'css');
            component($name, 'php');
            component($name, 'js');
        }
        elseif(file_exists("components/{$name}/{$name}.{$extention}")){
            switch ($extention) {
                case 'js':
                    echo '<script src="'.root_path("components/{$name}/{$name}.{$extention}").'?v='.filemtime(root("components/{$name}/{$name}.{$extention}")).'"></script>';
                    break;
                case 'css':
                    echo '<link rel="stylesheet" href="'.root_path("components/{$name}/{$name}.{$extention}").'?v='.filemtime(root("components/{$name}/{$name}.{$extention}")).'">';
                    break;
                case 'php':
                    require_once root("components/{$name}/{$name}.{$extention}");
                default:
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
                    require_once root("components/{$name}/{$tab}/{$tab}.{$extention}");
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
    function modal_script(String $component):void{
        $full_path="modal_component/{$component}/{$component}.js";
        echo '<script defer component="modal_'.$component.'" src="'.$full_path.'?v='.filemtime($full_path).'"></script>';
    }
    function module_script(String $component):void{
        $full_path="assets/js/components/{$component}.js";
        echo '<script component="module_'.$component.'" src="'.$full_path.'?v='.filemtime($full_path).'"></script>';
    }
    function root(string $path):string{
        return $_SERVER['DOCUMENT_ROOT'].root_path($path);
    }
    function theme():string{
        return 'blue';
    }
    function is_submit():bool{
        $ret=!empty($_POST)&&isset($_POST['submit']);
        return $ret;
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
    function add_date($add){
        $date = new DateTime();
        $date->modify($add);
        return $date->format('Y-m-d H:i:s');
    }
    function datetime() {
        return date('Y-m-d H:i:s');
    }
    function format_date(string $date):string{
        $date_value=new DateTime(date($date));
        return $date_value->format('Y-m-d');
    }
    function format(String $date, String $format):String{
        $date_value=new DateTime(date($date));
        return $date_value->format($format);
    }
    function unformat_date(?string $date,string $fallback='-'):string{
        if(!$date)return $fallback;
        else{
            $date_value=new DateTime(date($date));
            return $date_value->format('d/m/Y');
        }
    }
    function data_set(array $params):String{
        $arr_data_set=[];
        foreach($params as $k=>$v)$arr_data_set[]="data-{$k}=\"{$v}\"";
        return implode(' ',$arr_data_set);
    }
    function str_scape(string $text):string{
        return str_replace("'","\'",$text);
    }
    function first($table){
        return Select('*')->from($table)->first();
    }
    function italian_month($month){
        return match((int)$month){
            1=>'Gennaio',
            2=>'Febbraio',
            3=>'Marzo',
            4=>'Aprile',
            5=>'Maggio',
            6=>'Giugno',
            7=>'Luglio',
            8=>'Agosto',
            9=>'Settembre',
            10=>'Ottobre',
            11=>'Novembre',
            12=>'Dicembre'
        };
    }
    function _print($msg){
        echo $msg ."\n".'</br>';
        @ob_flush();
        @flush();
    }
    function _txt($txt){
        return $txt;
    }
    function _json_encode($array){
        return '\'' . htmlspecialchars(json_encode($array,JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT), ENT_QUOTES) . '\'';
    }