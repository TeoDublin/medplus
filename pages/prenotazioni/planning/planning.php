<?php component('calendar','css'); ?>
<?php style('pages/prenotazioni/planning/planning.css'); ?>
<?php 
    $rows=17;
    $id_terapista = cookie('id_terapista',first('terapisti')['id']);
    $data = cookie('data',date('Y-m-d'));
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
            $class='';
            if($row_inizio==$row){
                $class.=" {$plan['origin']} {$plan['origin']}_start";
                $id=$plan['id'];
                $motivo=$plan['motivo'];
            }
            if($row>$row_inizio&&$row<$row_fine){
                $class.=" {$plan['origin']} {$plan['origin']}_middle";
                $id=$plan['id'];
                $motivo=$plan['motivo'];
            }
            if($row_fine==$row){
                $class.=" {$plan['origin']} {$plan['origin']}_end";
                $id=$plan['id'];
                $motivo=$plan['motivo'];
            }
            if(!empty($class))break;
        }
        return ['class'=>$class,'id'=>$id,'motivo'=>($motivo=='Vuoto'?'':$motivo)];
    };
?>
<div id="planning">
    <div class="p-3 border my-1 d-flex" style="border-bottom: 0px!important; border-radius: 10px 10px 0 0; height: 100%;">
        <div class="d-flex flex-column flex-fill">
            <div class="d-flex flex-column">
                <div class="d-flex flex-fill my-1" >
                    <input onclick="openCalendar(event,this)" class="hover mx-auto card-title text-center py-2 border-0 date-target" id="data" value="<?php echo unformat_date($data);?>" onchange="changeDate()"readonly/>
                </div>
                <div class="d-flex mb-2">
                    <div class="d-flex flex-fill justify-content-center ">
                        <div class="w-35 d-flex flex-column text-center">
                            <div class="w-100 me-1">
                                <select type="text" class="form-control" id="terapista" name="terapista" value="<?php echo $id_terapista??'';?>" onchange="changeTerapista()">
                                    <?php
                                        foreach(Select('*')->from('terapisti')->get() as $value){
                                            $selected = (isset($id_terapista) && $id_terapista == $value['id']) ? 'selected' : '';
                                            echo "<option value=\"{$value['id']}\" class=\"ps-4  bg-white\" {$selected}>{$value['terapista']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column">
                <table class="table table-striped border-0" id="planning_table">
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
                                    <td scope="col" class="text-center border-0 border-end <?php echo $planning['class'];?> first" planning_motivi_id="<?php echo $planning['id'];?>" row="<?php echo $row;?>" onmouseenter="hoverRow(this);">
                                        <input class="w-100 p-0 m-0 text-center border-0 bg-transparent inizio" id="input_parent_inizio_<?php echo $row;?>" type="text" value="<?php echo _ora($row);?>"  readonly disabled/>
                                    </td>
                                    <td scope="col" class="text-center border-0 border-end impegno <?php echo $planning['class'];?>" planning_motivi_id="<?php echo $planning['id'];?>" row="<?php echo $row;?>" onclick="sbarraClick(this);"  onmouseenter="hoverRow(this);">
                                        <span class="w-100 p-0 m-0 text-center border-0 bg-transparent"><?php echo $planning['motivo'];?></span>
                                    </td>
                                    <td scope="col" class="text-center border-0 border-end <?php echo $planning['class'];?> last" planning_motivi_id="<?php echo $planning['id'];?>" row="<?php echo $row;?>" onmouseenter="hoverRow(this);">
                                        <input class="w-100 p-0 m-0 text-center border-0 bg-transparent note" id="input_parent_note_<?php echo $row;?>"/>
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
<?php component('calendar','js'); ?>
<?php script('pages/prenotazioni/planning/planning.js'); ?>