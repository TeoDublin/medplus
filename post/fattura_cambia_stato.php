<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    function _percorsi(){
        return Select('f.data,pf.id_origine')
            ->from('pagamenti_fatture','pf')
            ->left_join('fatture f ON pf.id_fattura = f.id')
            ->where("pf.id_fattura={$_REQUEST['id']}")->get();
    }
    Update('fatture')->set(['stato'=>$_REQUEST['stato']])->where("id={$_REQUEST['id']}");
    foreach (_percorsi() as $percorso) {
        if($percorso['origine']!='corsi')Sedute()->refresh($percorso['id_origine'],$percorso['data'],'Fattura');
    }
