<?php 
    $session=Session();
    $ruolo=$session->get('ruolo')??false;
    $data = cookie('data',($_REQUEST['data']??date('Y-m-d')));
    $_ore=function()use(&$data){
        $ret=$o=[];
        $ore=Select('DATE_FORMAT(ora,"%H") as ora')
        ->from('planning_row','pr')
        ->inner_join("view_planning vp on pr.id = vp.row_inizio AND vp.data = '{$data}'")
        ->orderby('pr.id')
        ->groupby('pr.id')
        ->get();
        foreach ($ore as $key => $value) {
            if(!in_array($value['ora'],$o)){
                $ret[]=$value;
                $o[]=$value['ora'];
            }
        }
        return $ret;
    };
    $_t=function($id_terapista)use(&$ore,&$data,&$ruolo){
        $ret=[];
        foreach($ore as $o){
            $got_o=false;
            $vp=Select('*,DATE_FORMAT(STR_TO_DATE(ora_inizio, "%H:%i"), "%H") as f_ora_inizio')
                ->from('view_planning')
                ->where("`data`='{$data}' AND id_terapista={$id_terapista}");
            if($ruolo=='display')$vp->and("( tipo_pagamento IS NULL OR tipo_pagamento <> 'Senza Fattura' )");
            $vp=$vp->get();
            foreach($vp as $v){
                if($v['f_ora_inizio']==$o['ora']){
                    $ret[]=$v;
                    $got_o=true;
                    break;
                }
            }
            if(!$got_o)$ret[]=[];
        }
        return $ret;
    };
    $ore=$_ore();
    $t1=$_t(1);
    $t2=$_t(2);
    $t3=$_t(3);
    $t4=$_t(4);
    style('pages/prenotazioni/cartaceo/cartaceo.css');
?>
<div>
    <div class="w-100 align-content-center justify-content-center d-flex py-2">
        <button class="w-30 btn align-content-center justify-content-center" onclick="window.modalHandlers['cartaceo'].printTable()">
            <?php echo icon('print.svg'); ?>
            Stampa</button>
    </div>
    <div class="w-100 d-flex flex-row">
        <div class="w-10 me-0 text-center align-content-center justify-content-center"
            onclick="window.modalHandlers['cartaceo'].removeDay(this)">
            <button class="btn btn-light">
                <?php echo icon("arrow-filled-left.svg",'black',20,50); ?>
            </button>
        </div>
        <div class="flex-fill">
            <table class="table w-100 table-striped">
                <thead>
                    <div class="w-100 d-flex flex-row justify-content-center align-content-center mt-1">
                        <div class="form-control text-end w-10" style="border:none!important">
                            <span id="date-label"><?php echo italian_date($data,'%A'); ?></span>
                        </div>
                        <div>
                            <input
                                style="border:none!important"
                                type="date"
                                id="data" 
                                name="data" 
                                class="form-control text-start ps-0"
                                value="<?php echo $data;?>" 
                                onchange="window.modalHandlers['cartaceo'].change(this)"
                            />
                        </div>
                    </div>    
                    <tr>
                        <th>Ora</th>
                        <th>Daniela</th>
                        <th>Ora</th>
                        <th>Enrica</th>
                        <th>Ora</th>
                        <th>Claudia</th>
                        <th>Ora</th>
                        <th>Giancarlo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        for($i=0;$i<20;$i++){
                            echo "<tr>
                                <td>{$t1[$i]['ora_inizio']}</td>
                                <td>{$t1[$i]['acronimo']}</td>
                                <td>{$t2[$i]['ora_inizio']}</td>
                                <td>{$t2[$i]['acronimo']}</td>
                                <td>{$t3[$i]['ora_inizio']}</td>
                                <td>{$t3[$i]['acronimo']}</td>
                                <td>{$t4[$i]['ora_inizio']}</td>
                                <td>{$t4[$i]['acronimo']}</td>
                            </tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div  class="w-10 ms-0 text-center align-content-center justify-content-center"
            onclick="window.modalHandlers['cartaceo'].addDay(this)">
            <button class="btn btn-light">
                <?php echo icon("arrow-filled-right.svg",'black',20,50); ?>
            </button>
        </div>
    </div>
</div>
<?php script('pages/prenotazioni/cartaceo/cartaceo.js'); ?>