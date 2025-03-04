<?php 
    $rows=$total_rows=53;$tables_by_page=4;
    $session=Session();
    $elementi=$session->get('elementi')??[];
    $ruolo=$session->get('ruolo')??false;
    $id_terapista = cookie('id_terapista',$_REQUEST['id_terapista']??first('terapisti')['id']);
    $terapisti=Select('*')->from('terapisti')->orderby('id ASC')->get();
    $groups=count($terapisti);
    style('components/planning/planning.css'); 
    $data = cookie('data',($_REQUEST['data']??date('Y-m-d')));
    function _ora($row){
        $ora = new DateTime('07:00');
        for ($i=1; $i < $row; $i++) { 
            $ora->add(new DateInterval("PT15M"));
        }
        return $ora->format('H:i');
    };
    $_terapista_planning=function($ret=[])use(&$terapisti,&$data){
        foreach($terapisti as $terapista){
            $view_planning=Select('*')
                ->from('view_planning')
                ->where("id_terapista={$terapista['id']}")
                ->and("data='{$data}'")
                ->get();
            $ret[$terapista['id']]['planning']=$view_planning;
            $ret[$terapista['id']]['terapista']=$terapista;
        }
        return $ret;
    }; 
    $_planning=function ($id_terapista,$row)use(&$terapista_planning){
        $class='';$id='';$origin='empty';
        foreach ($terapista_planning[$id_terapista]['planning'] as $plan) {
            $row_inizio=(int)$plan['row_inizio'];
            $row_fine=(int)$plan['row_fine'];
            $stato=$plan['stato']=='-'?'':$plan['stato'];
            $class='';
            if($row_inizio==$row){
                $class.=" {$plan['origin']} {$plan['origin']}_start {$stato}";
                $id=$plan['id'];
                $motivo=$plan['motivo'];
                $origin=$plan['origin'];
            }
            if($row>$row_inizio&&$row<$row_fine){
                $class.=" {$plan['origin']} {$plan['origin']}_middle {$stato}";
                $id=$plan['id'];
                $motivo=$plan['motivo'];
                $origin=$plan['origin'];
            }
            if($row_fine==$row){
                $class.=" {$plan['origin']} {$plan['origin']}_end {$stato}";
                $id=$plan['id'];
                $motivo=$plan['motivo'];
                $origin=$plan['origin'];
            }
            if(!empty($class))break;
        }
        return ['class'=>$class,'id'=>$id,'motivo'=>($motivo=='Vuoto'?'':$motivo),'origin'=>$origin];
    };
    $_table=function($id_terapista)use(&$rows,&$_planning,&$terapista_planning,&$elementi){
        ?>
        <div class="d-flex flex-column flex-fill text-center p-1 mt-2 table-terapista">
            <div class="text-center bg-light bg-opacity-25 p-1 pt-2 my-1">
                <h4><?php echo $terapista_planning[$id_terapista]['terapista']['terapista']; ?></h4>
            </div>
            <div class="text-center">
                <table class="planning-table table table-striped border-0">
                    <thead>
                        <tr>
                            <th class="text-center bg-light border-1 border-white">Ora</th>
                            <th class="text-center bg-light border-1 border-white">Motivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        for($row=1; $row<=$rows; $row++){ 
                            $planning = $_planning($id_terapista,$row); ?>
                            <tr class="planning-tr">
                                <td 
                                    scope="col" 
                                    class="text-center border-0 border-end <?php echo $planning['class'];?> first w-15" 
                                    planning_motivi_id="<?php echo $planning['id'];?>" 
                                    row="<?php echo $row;?>" 
                                    <?php 
                                        if(in_array('row_click_planning',$elementi)){?>
                                            onclick="window.modalHandlers['planning'].rowClick(this,'<?php echo $planning['origin']; ?>','<?php echo $id_terapista; ?>');"<?php
                                        }
                                    ?>
                                    onmouseenter="window.modalHandlers['planning'].enterRow(this,'<?php echo $planning['origin']; ?>');"
                                    >
                                    <input class="w-100 p-0 m-0 text-center border-0 bg-transparent inizio" id="input_parent_inizio_<?php echo $row;?>" type="text" value="<?php echo _ora($row);?>"  readonly disabled/>
                                </td>
                                <td 
                                    scope="col" 
                                    class="text-center border-0 border-end impegno <?php echo $planning['class'];?> last" 
                                    planning_motivi_id="<?php echo $planning['id'];?>" 
                                    row="<?php echo $row;?>" 
                                    <?php 
                                        if(in_array('row_click_planning',$elementi)){?>
                                            onclick="window.modalHandlers['planning'].rowClick(this,'<?php echo $planning['origin']; ?>','<?php echo $id_terapista; ?>');"<?php
                                        }
                                    ?>
                                    onmouseenter="window.modalHandlers['planning'].enterRow(this,'<?php echo $planning['origin']; ?>');"
                                    >
                                    <span class="w-100 p-0 m-0 text-center border-0 bg-transparent"><?php echo $planning['motivo'];?></span>
                                </td>
                            </tr><?php
                        }?>
                    </tbody>
                </table>
            </div>     
        </div><?php
    };
    $terapista_planning=$_terapista_planning();
?>
<div>
    <div class="p-3 border my-1 d-flex" style="border-bottom: 0px!important; border-radius: 10px 10px 0 0; height: 100%;">
        <div class="w-100">
            <div class="mx-auto d-flex flex-column flex-md-row p-3">
                <div class="flex-fill me-2 mb-2 text-center">
                    <label class="form-label" for="data">Data</label>
                    <input
                        type="date"
                        id="data" 
                        name="data" 
                        class="form-control text-center"
                        value="<?php echo $data;?>" 
                        onchange="window.modalHandlers['planning'].change(this)"
                    />
                </div>
            </div>
            <div class="d-flex flex-column flex-grow-0">
                <div class="d-flex flex-row flex-wrap gap-3 ms-3">
                    <div class="d-flex align-items-center mb-2 p-1 div-color-box">
                        <input type="color" class="corso_bg color-box color-picker" data-target="--base-bg-corso">
                        <span class="ms-2">Corso</span>
                    </div>
                    <div class="d-flex align-items-center mb-2 p-1 div-color-box">
                        <input type="color" class="color-box color-picker" data-target="--base-bg-sbarra">
                        <span class="ms-2">Sbarrato</span>
                    </div>
                    <div class="d-flex align-items-center mb-2 p-1 div-color-box">
                        <input type="color" class="color-box color-picker" data-target="--base-bg-seduta">
                        <span class="ms-2">Trattamento</span>
                    </div>
                    <div class="d-flex align-items-center mb-2 p-1 div-color-box">
                        <input type="color" class="color-box color-picker" data-target="--base-bg-colloquio">
                        <span class="ms-2">Colloquio</span>
                    </div>
                </div>
                <div class="my-3 d-flex d-none preferences-btn">
                    <button id="save-btn" class="btn btn-primary w-100 w-md-20">Salva Preferenze</button>
                    <button id="discard-btn" class="btn btn-secondary ms-2 w-100 w-md-20">Annulla</button>
                </div>
            </div>
                <div class="d-flex w-100 py-3">
                    <div class="flex-fill flex-column">
                        <div class="p-1">
                            <div class="table-container"><?php
                                foreach($terapisti as $terapista)$_table($terapista['id']);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<div id="sbarra"></div>
<?php script('components/planning/planning.js'); ?>