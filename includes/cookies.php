<?php

$current_cookie = _page_cookie();

$_set_page_cookie =function(string $key=null, string $value = null)use(&$current_cookie): array {
    
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
};

function _page_cookie():array{
    return isset($_COOKIE[page()]) ? json_decode($_COOKIE[page()], true) : [];
}

function _tab_cookie($tab):array{
    return isset($_COOKIE[$tab]) ? json_decode($_COOKIE[$tab], true) : [];
}

function cookie(string $key, $fallback=false):string{
    if(isset($_REQUEST['skip_cookie'])){
        $ret=$_REQUEST[$key]??$fallback;
    }
    else{
        $page_cookie=_page_cookie();
        $ret=$page_cookie[$key] ?? $fallback;
    }
    return $ret;
}

if(!request('skip_cookie')&&strpos('/jobs/',$_SERVER['REQUEST_URI'])== false){
    if(($_SERVER['REQUEST_URI']!=strtok($_SERVER['REQUEST_URI'], '?'))&&empty($_POST)){
        $page_cookie = $_set_page_cookie();   
        redirect(strtok($_SERVER['REQUEST_URI'], '?'));
    }
    elseif(isset($_REQUEST['cookie'])){
        setcookie(page(), json_encode(array_merge($_REQUEST['cookie'], $current_cookie)), time() + 3600, '/');
        unset($_REQUEST['cookie']);
    }
}

if(isset($current_cookie['unset_tab']) && isset($current_cookie['tab'])){
    $tab = $current_cookie['tab'];
    $unset = json_decode($current_cookie['unset_tab'],true);
    $tab_cookie = _tab_cookie($tab);

    foreach ($unset as $k) {
        unset($tab_cookie[$k]);
    }

    unset($current_cookie['unset_tab']);
    
    setcookie($tab, json_encode($tab_cookie), time() + 3600, '/');
    setcookie(page(), json_encode($current_cookie), time() + 3600, '/');
}


if(isset($current_cookie['unset'])){
    $unset = is_array($current_cookie['unset']) ? $current_cookie['unset'] : [$current_cookie['unset']];

    foreach ($unset as $k) {
        unset($current_cookie[$k]);
    }

    unset($current_cookie['unset']);
    
    setcookie(page(), json_encode($current_cookie), time() + 3600, '/');
}
