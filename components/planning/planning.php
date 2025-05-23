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
    $_terapista_planning=function($ret=[])use(&$terapisti,&$data,&$ruolo){
        foreach($terapisti as $terapista){
            $view_planning=Select('*')
                ->from('view_planning')
                ->where("id_terapista={$terapista['id']}")
                ->and("data='{$data}'");
            if($ruolo=='display')$view_planning->and("( tipo_pagamento IS NULL OR tipo_pagamento <> 'Senza Fattura' )");
            $view_planning=$view_planning->get();
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
            $row_span=$origin=='empty'?1:(int)$plan['row_span'];
            if(!empty($class))break;
        }
        return ['class'=>$class,'id'=>$id,'motivo'=>($motivo=='Vuoto'?'':$motivo),'origin'=>$origin, 'row_span'=>$row_span??1];
    };
    $_table=function($id_terapista)use(&$rows,&$_planning,&$terapista_planning,&$elementi){
        ?>
        <div class="d-flex flex-column text-center p-1 mt-2 table-terapista w-md-25">
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
                        $doing_span=0;
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
                                </td><?php 
                                    if($doing_span==0){?>
                                        <td rowspan="<?php echo $planning['row_span'];?>"
                                            scope="col" 
                                            class="text-center border-0 border-end impegno <?php echo $planning['class'];?> td" 
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
                                        <?php
                                        $doing_span=$planning['row_span']-1;
                                    }
                                    else {
                                        $doing_span --;
                                    }
                                ?>
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
            <div class="mx-auto d-flex flex-row mt-3 p-0 w-md-30 align-content-center justify-content-center">
                <label class="form-label" for="data">Data</label>
            </div>
            <div class="mx-auto d-flex flex-row mt-0 pt-0 w-md-30 align-content-center justify-content-center">
                <div class="flex-fill me-0 text-center w-md-10 align-content-center justify-content-center"
                    onclick="window.modalHandlers['planning'].removeDay(this)">
                    <button class="btn btn-light">
                        <?php echo icon("arrow-filled-left.svg",'black',40,40); ?>
                    </button>
                </div>
                <div class="flex-fill mx-1 m-md-0 text-center align-content-center justify-content-center date-label">
                    <div class="w-100">
                        <span><?php echo italian_date($data,'%A'); ?></span>
                    </div>
                    <input
                        type="date"
                        id="data" 
                        name="data" 
                        class="form-control text-center date-pick"
                        value="<?php echo $data;?>" 
                        onchange="window.modalHandlers['planning'].change(this)"
                    />
                </div>
                <div  class="flex-fill ms-0 text-center w-md-10 align-content-center justify-content-center"
                    onclick="window.modalHandlers['planning'].addDay(this)">
                    <button class="btn btn-light">
                        <?php echo icon("arrow-filled-right.svg",'black',40,40); ?>
                    </button>
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