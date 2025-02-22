<?php 
    $rows = cookie('rows',($_REQUEST['rows']??17));
    $total_rows=51;$groups=ceil($total_rows/$rows);
    style('components/planning/planning.css'); 
    echo "<style>
        @media (min-width: 768px) {
            .planning-table {
                width: ".(99/$groups)."%;
                max-width: ".(99/$groups)."%;
                
            }
        }
    </style>";
?>
<?php 
    $id_terapista = cookie('id_terapista',($_REQUEST['id_terapista']??first('terapisti')['id']));
    $data = cookie('data',($_REQUEST['data']??date('Y-m-d')));
    $result=Select('*')->from('view_planning')->where("id_terapista={$id_terapista}")->and("data='{$data}'")->get();
    function _ora($row){
        $ora = new DateTime('07:00');
        for ($i=1; $i < $row; $i++) { 
            $ora->add(new DateInterval("PT15M"));
        }
        return $ora->format('H:i');
    };
    $_table = function($table_index)use(&$_planning,&$rows){
        $th_class=$table_index>0?'sm-hidden':'';
        ?>
        <table class="planning-table table table-striped border-0">
            <thead class="<?php echo $th_class; ?>">
                <tr><th class="text-center">Ora</th><th class="text-center">Motivo</th></tr>
            </thead>
            <tbody><?php 
                $session=Session();
                $elementi=$session->get('elementi')??[];
                for($i=1; $i<=$rows; $i++){
                    $row = $i + $rows*$table_index; $planning = $_planning($row); ?>
                    <tr class="planning-tr">
                        <td 
                            scope="col" 
                            class="text-center border-0 border-end <?php echo $planning['class'];?> first w-15" 
                            planning_motivi_id="<?php echo $planning['id'];?>" 
                            row="<?php echo $row;?>" 
                            <?php 
                                if(in_array('row_click_planning',$elementi)){?>
                                    onclick="window.modalHandlers['planning'].rowClick(this,'<?php echo $planning['origin']; ?>');"<?php
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
                                    onclick="window.modalHandlers['planning'].rowClick(this,'<?php echo $planning['origin']; ?>');"<?php
                                }
                            ?>
                            onmouseenter="window.modalHandlers['planning'].enterRow(this,'<?php echo $planning['origin']; ?>');"
                            >
                            <span class="w-100 p-0 m-0 text-center border-0 bg-transparent"><?php echo $planning['motivo'];?></span>
                        </td>
                    </tr><?php
                }?>
            </tbody>
        </table><?php
    };
    $_planning = function ($row)use($result){
        $class='';$id='';$origin='empty';
        foreach ($result as $plan) {
            $row=(int)$row;
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
?>
<div>
    <div class="p-3 border my-1 d-flex" style="border-bottom: 0px!important; border-radius: 10px 10px 0 0; height: 100%;">
        <div class="w-100">
            <div class="mx-auto d-flex flex-column flex-md-row p-3">
                <div class="w-md-30 me-2 mb-2 text-center">
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
                <div class="flex-fill text-center mb-2">
                    <label class="form-label" for="terapista">Terapista</label>
                    <select
                        id="terapista" 
                        name="terapista"
                        class="form-select text-center" 
                        value="<?php echo $id_terapista??'';?>" 
                        onchange="window.modalHandlers['planning'].change(this)"
                        >
                        <?php
                            foreach(Select('*')->from('terapisti')->get() as $value){
                                $selected = (isset($id_terapista) && $id_terapista == $value['id']) ? 'selected' : '';
                                echo "<option value=\"{$value['id']}\" class=\"ps-4  bg-white\" {$selected}>{$value['terapista']}</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="d-w-20 ms-2 text-center d-none d-md-block">
                    <label class="form-label" for="rows">Righe</label>
                    <input
                        type="number"
                        id="rows" 
                        name="rows" 
                        class="form-control text-center"
                        value="<?php echo $rows;?>" 
                        onchange="window.modalHandlers['planning'].change(this)"
                    />
                </div>
            </div>
            <div class="d-flex flex-row gap-3 ms-3">
                <div class="d-flex align-items-center mb-2">
                    <span class="color-box bg-colorfull2 me-2"></span> Sbarrato
                </div>
                <div class="d-flex align-items-center mb-2">
                    <span class="color-box bg-colorfull3 me-2"></span> Trattamento
                </div>
                <div class="d-flex align-items-center mb-2">
                    <span class="color-box bg-colorfull me-2"></span> Corso
                </div>
            </div>
            <div class="table-container"><?php
                for($i=0;$i<$groups;$i++)$_table($i);
                ?>
            </div>
        </div>
    </div>
</div>
<div id="sbarra"></div>
<?php script('components/planning/planning.js'); ?>