<?php
function _set_page_cookie(string $key=null, string $value = null): array {
    $current_cookie = _page_cookie();
    $request_cookie = isset($_GET) ? $_GET : [];
    $merge_cookie = [];
    foreach ($request_cookie as $k => $v) {
        if($v=='unset'){
            unset($current_cookie[$k]);
        }
        else$merge_cookie[$k]=$v;
    }
    $page_cookie = array_merge($current_cookie, $merge_cookie);
    if($key)$page_cookie[$key]=$value;
    setcookie(page(), json_encode($page_cookie), time() + 3600, '/');
    return $page_cookie;
}
function _page_cookie():array{
    return isset($_COOKIE[page()]) ? json_decode($_COOKIE[page()], true) : [];
}
function cookie(string $key, $fallback=false):string{
    if($_REQUEST['skip_cookie'])$ret=$_REQUEST[$key]??$fallback;
    else{
        $page_cookie=_page_cookie();
        $ret=$page_cookie[$key] ?? $fallback;
    }
    return $ret;
}
if(!request('skip_cookie')&&strpos('/jobs/',$_SERVER['REQUEST_URI'])== false){
    if(($_SERVER['REQUEST_URI']!=strtok($_SERVER['REQUEST_URI'], '?'))&&empty($_POST)){
        $page_cookie = _set_page_cookie();   
        redirect(strtok($_SERVER['REQUEST_URI'], '?'));
    }
    else{
        $unset=[];
        foreach($_REQUEST as $key => $value) if($value=='unset')$unset[]=$key;
        if(!empty($unset)){
            $current_cookie = _page_cookie();
            foreach ($unset as $k) {
                unset($current_cookie[$k]);
            }
            setcookie(page(), json_encode($current_cookie), time() + 3600, '/');
        }
    }
}
