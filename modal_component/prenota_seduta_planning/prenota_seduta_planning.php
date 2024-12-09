<?php style('modal_component/prenota_seduta_planning/prenota_seduta_planning.css');
$rows=17;
$id_terapista = cookie('id_terapista',first('terapisti')['id']);
$data = cookie('date',date('Y-m-d'));
$result=Select('*')->from('planning')->where("id_terapista={$id_terapista}")->and("data='{$data}'")->get();
function _ora($row){
    $ora = new DateTime('07:00');
    for ($i=1; $i < $row; $i++) { 
        $ora->add(new DateInterval("PT15M"));
    }
    return $ora->format('H:i');
};
$_planning = function ($row)use($result){
    $class='';$id='';
    foreach ($result as $plan) {
        $row=(int)$row;
        $row_inizio=(int)$plan['row_inizio'];
        $row_fine=(int)$plan['row_fine'];
        if($row_inizio==$row){
            $class='sbarra sbarra_start';
            $id=$plan['id'];
            $motivo=$plan['motivo'];
            break;
        }
        elseif($row>$row_inizio&&$row<$row_fine){
            $class='sbarra sbarra_middle';
            $id=$plan['id'];
            $motivo=$plan['motivo'];
            break;
        }
        elseif($row_fine==$row){
            $class='sbarra sbarra_end';
            $id=$plan['id'];
            $motivo=$plan['motivo'];
            break;
        }
    }
    return ['class'=>$class,'id'=>$id,'motivo'=>($motivo=='Vuoto'?'':$motivo)];
};
?>
<div class="modal bg-dark bg-opacity-50" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xxl modal-xl modal-fullscreen">
        <div class="modal-content px-3 text-center">
            <div class="modal-header">
                <h4>Planning</h4>
                <button type="button" class="btn-resize" aria-hidden="true" onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="p-2">
                <div class="no-scroll">
                    <div class="p-3 border my-1 d-flex" style="border-bottom: 0px!important; border-radius: 10px 10px 0 0; height: 100%;">
                        <div class="d-flex flex-column flex-fill">
                            <div class="d-flex flex-column">
                                <table class="table table-striped border-0" id="prenota-prenota_table">
                                    <thead>
                                        <tr class="align-middle">
                                            <th scope="col" class="text-center" rowspan="2">Ora</th>
                                            <th scope="col" class="text-center w-25" rowspan="2">Impegno</th>
                                            <th scope="col" class="text-center" rowspan="2">TR</th>
                                            <th scope="col" class="text-center" rowspan="2">Ora</th>
                                            <th scope="col" class="text-center w-25" rowspan="2">Impegno</th>
                                            <th scope="col" class="text-center" rowspan="2">TR</th>
                                            <th scope="col" class="text-center" rowspan="2">Ora</th>
                                            <th scope="col" class="text-center w-25" rowspan="2">Impegno</th>
                                            <th scope="col" class="text-center" rowspan="2">TR</th>
                                        </tr>
                                    </thead>
                                    <tbody><?php 
                                        for($i=1;$i<=$rows;$i++){ ?>
                                            <tr><?php
                                                for($col=1;$col<=3;$col++){$row=$i+($rows*($col-1)); $planning=$_planning($row);?>
                                                    <td scope="col" class="text-center border-0 border-end <?php echo $planning['class'];?> first" prenota_motivi_id="<?php echo $planning['id'];?>" row="<?php echo $row;?>" onmouseenter="prenotaHoverRow(this);">
                                                        <input class="w-100 p-0 m-0 text-center border-0 bg-transparent inizio" id="input_inizio<?php echo _ora($row);?>" type="text" value="<?php echo _ora($row);?>"  readonly disabled/>
                                                    </td>
                                                    <td scope="col" class="text-center border-0 border-end impegno <?php echo $planning['class'];?>" prenota_motivi_id="<?php echo $planning['id'];?>" row="<?php echo $row;?>" onclick="prenotaSbarraClick(this);"  onmouseenter="prenotaHoverRow(this);">
                                                        <span class="w-100 p-0 m-0 text-center border-0 bg-transparent"><?php echo $planning['motivo'];?></span>
                                                    </td>
                                                    <td scope="col" class="text-center border-0 border-end <?php echo $planning['class'];?> last" prenota_motivi_id="<?php echo $planning['id'];?>" row="<?php echo $row;?>" onmouseenter="prenotaHoverRow(this);">
                                                        <input class="w-100 p-0 m-0 text-center border-0 bg-transparent note" id="input_note<?php echo _ora($row);?>"/>
                                                    </td><?php
                                                    }?>
                                            </tr><?php
                                        }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" data-bs-dismiss="modal" class="btn btn-secondary">Anulla</a>
                <a href="#" class="btn btn-primary" onclick="btnSalva('<?php echo $_REQUEST['id_modal'];?>')">Salva</a>
            </div>
        </div>
    </div>
</div>
<div class="p-2" id="planning-prenota_seduta_planning_ora"></div>
<?php script('modal_component/prenota_seduta_planning/prenota_seduta_planning.js'); ?>
