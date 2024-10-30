<?php 
    require '../includes.php';
    function _operation(){
        $ret=$_POST['operation'];
        unset($_POST['operation']);
        return $ret;
    }
    switch (_operation()) {
        case 'all':
            if($_POST['id']!="")$id_cliente=$_POST['id'];
            else $id_cliente=Clienti()->insert(array_diff_key($_POST,array_flip(['id','ora','row','id_terapista','data','id_trattamento'])));
            $params=array_filter(['row'=>$_POST['row'],'data'=>$_POST['data'],'ora'=>$_POST['ora'],'id_terapista'=>$_POST['id_terapista'],'id_trattamento'=>$_POST['id_trattamento'],'id_cliente'=>$id_cliente]);
            if($id=Select('p.*')->from('planning','p')
                ->where("p.row={$_POST['row']}")
                ->and("p.data='".format_date($_POST['data'])."'")
                ->and("p.id_terapista = {$_POST['id_terapista']}")
                ->col('id')
            ){
                Planning()->update(array_merge($params,['id'=>$id]));
            }
            else Planning()->insert($params);
            break;
        case 'hour':
            $params=array_filter(['row'=>$_POST['row'],'data'=>$_POST['data'],'ora'=>$_POST['ora'],'id_terapista'=>$_POST['id_terapista']]);
            if($id=Planning()->first(['row'=>$_POST['row'], 'id_terapista'=>$_POST['id_terapista']])['id'])Planning()->update(array_merge($params,['id'=>$id]));
            else Planning()->insert($params);
            break;
    }
