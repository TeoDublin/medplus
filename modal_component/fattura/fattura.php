<?php style('modal_component/fattura/fattura.css'); ?>
<?php 
    function _deleted_index($index){
        return Select('fe.index')
        ->from('fatture_eliminate','fe')
        ->left_join('fatture f on fe.index = f.index')
        ->where('f.id IS NULL')
        ->and("fe.index <> {$index}")
        ->get();
    }
    function _index($oggetti){
        if($oggetti['index'])return $oggetti['index'];
        else{
            $index=Select('max(`index`) as mx')->from('fatture')->first_or_false();
            if(!$index['mx'])$index=Select("JSON_EXTRACT(setup, '$.first_index') as first_index")->from('setup')->where("`key`='fatture'")->col('first_index');
            else $index=(int)$index['mx']+1;
            return $index; 
        }
    }
    function _total($oggetti){
        $ret=0;
        foreach($oggetti??[] as $obj){
            $ret+=(int)$obj['importo'];
        }
        return $ret;
    }
    if($_REQUEST['id_fattura']){
        $view_fatture=Select('*')->from('view_fatture')->where("id={$_REQUEST['id_fattura']}")->first();
        $id_cliente=$view_fatture['id_cliente'];
        $data_pagamento=$view_fatture['data'];
        $metodo_pagamento=$view_fatture['metodo'];
        $table=Select('*')->from('fatture_table')->where("id_fattura={$_REQUEST['id_fattura']}")->get_or_false();
        $oggetti=Select('*')->from('pagamenti_fatture')->where("id_fattura={$_REQUEST['id_fattura']}")->get();
        $index=$view_fatture['index'];
        $total=(double)$view_fatture['importo'];
        $inps=(double)$view_fatture['inps'];
        $bollo=(double)$view_fatture['bollo'];
    }
    else{
        $id_cliente=$_REQUEST['id_cliente'];
        $data_pagamento=$_REQUEST['data_pagamento'];
        $metodo_pagamento=$_REQUEST['metodo_pagamento'];
        $table=$_REQUEST['table'];
        $oggetti=$_REQUEST['oggetti'];
        $index=_index($oggetti);
        $total=_total($oggetti);
        $inps=round($total*0.04,2,PHP_ROUND_HALF_UP);
        $bollo=($total+$inps)>70?2:0;
    }

    $sum=$total+$inps+$bollo;

    
?>
<div class="modal bg-dark bg-opacity-50" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog modal-xl">
        <div class="modal-content px-3 text-center">
            <div class="modal-header">
                <h4>Fattura</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="id_cliente" value="<?php echo $id_cliente; ?>" hidden/>
                <div class="p-2 card mt-2">
                    <div class="pb-0 mb-0 card-body w-100">
                        <div class="d-flex flex-column w-100 my-3">
                            <div class="d-flex flex-row" id="date_div">
                                <div><div class="d-grid justify-content-center align-content-center h-100 mx-2">Fattura n:</div></div>
                                <div class="w-25">
                                    <select class="form-control" id="index" name="index"  value="<?php echo $index;?>">
                                        <option value="<?php echo $index;?>" selected><?php echo $index;?></option>
                                        <?php 
                                            foreach(_deleted_index($index) as $del){
                                                echo "<option value=\"{$del['index']}\">{$del['index']}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div><div class="d-grid justify-content-center align-content-center h-100 mx-2">del:</div></div>
                                <div class="w-25"><input type="date" class="form-control" id="data_pagamento" name="data_pagamento" value="<?php echo $data_pagamento??now('Y-m-d'); ?>"/></div>
                                <div><div class="d-grid justify-content-center align-content-center h-100 mx-2">Metodo di Pagamento:</div></div>
                                <div class="flex-fill">
                                    <select class="form-select w-100" value="<?php echo $metodo_pagamento??'Pos';?>" name="metodo_pagamento" id="metodo_pagamento">
                                        <option value="Pos">Pos</option>
                                        <option value="Contanti">Contanti</option>
                                        <option value="Bonifico">Bonifico Bancario</option>
                                    </select>                                    
                                </div>                            
                            </div>
                        </div>

                        
                    </div>
                    <div class="d-flex flex-col card mx-3" body>
                        <div class="card-body d-flex flex-row pb-0">
                            <div class="flex-col w-md-50 oggetti">
                                <div class="card-body pe-1 pb-0 text-center titleOggetti">
                                    <span class="d-none d-md-block">OGGETTO</span>
                                    <span class="d-md-none">OG.</span>
                                </div>
                                <?php 
                                    if($table){
                                        $row=1;
                                        foreach ($table as $tr) {
                                            echo "<div class=\"card-body pe-1 pb-0 pt-1 oggetto\" id=\"row{$row}\"><input id=\"oggetto{$row}\" class=\"form-control\" value=\"{$tr['oggetto']}\"/></div>";
                                            $row++;
                                        }
                                    } 
                                    else echo "<div class=\"card-body pe-1 pb-0 pt-1 oggetto\" id=\"row1\"><input id=\"oggetto1\" class=\"form-control\" value=\"Interventi/sedute di fisioterapia\"/></div>";
                                ?>
                                <div class="card-body pe-1 pb-0 pt-1"><input  class="form-control" value="Rivalsa INPS" disabled/></div>
                                <div class="card-body pe-1 pb-0 pt-1"><input  class="form-control" value="Bollo" disabled/></div>
                            </div>
                            <div class="flex-col w-md-41 ms-0 importi">
                                <div class="card-body ps-0 pe-1 pb-0 text-center titleImporti">
                                    <span class="d-none d-md-block">IMPORTI</span>
                                    <span class="d-md-none">IMP.</span>
                                </div>
                                <?php 
                                    if($table){
                                        $row=1;
                                        foreach ($table as $tr) {
                                            echo "<div class=\"card-body ps-0 pe-1 pb-0 pt-1 importo importo_row\" id=\"row{$row}\"><input type=\"number\" id=\"importo{$row}\" class=\"form-control\" value=\"{$tr['importo']}\" onchange=\"window.modalHandlers['fattura'].addTotal(this)\"/></div>";
                                            $row++;
                                        }
                                    } 
                                    else echo "<div class=\"card-body ps-0 pe-1 pb-0 pt-1 importo importo_row\" id=\"row1\"><input type=\"number\" id=\"importo1\" class=\"form-control\" value=\"{$total}\" onchange=\"window.modalHandlers['fattura'].addTotal(this)\"/></div>";
                                ?>
                                <div class="card-body ps-0 pe-1 pb-0 pt-1"><input type="number" id="inps" class="form-control" value="<?php echo $inps;?>" disabled/></div>
                                <div class="card-body ps-0 pe-1 pb-0 pt-1"><input type="number" id="bollo" class="form-control" value="<?php echo $bollo;?>" disabled/></div>
                            </div>
                            <div class="flex-col w-md-10 ms-0 btns">
                                <div class="card-body ps-0 pe-1 pb-0 text-center w-10"><span class="">#</span></div>
                                <?php 
                                    if($table){
                                        $row=1;
                                        foreach ($table as $tr) {?>
                                            <div class="card-body ps-0 pe-1 pb-0 pt-1 delBtn" title="ELIMINA"  id="row<?php echo $row;?>"
                                                onclick="window.modalHandlers['fattura'].deleteBtnClick(this);" 
                                                onmouseenter="window.modalHandlers['fattura'].deleteBtnEnter(this);" 
                                                onmouseleave="window.modalHandlers['fattura'].deleteBtnLeave(this);">
                                                <div class="pe-0" >
                                                    <button class="btn btn-primary w-100">
                                                        <a class=""><?php echo icon('bin.svg','white',15,15); ?></a>
                                                    </button>
                                                </div>
                                            </div><?php  
                                            $row++;
                                        }
                                    } 
                                    else{?>
                                        <div class="card-body ps-0 pe-1 pb-0 pt-1 delBtn" title="ELIMINA"  id="row1"
                                            onclick="window.modalHandlers['fattura'].deleteBtnClick(this);" 
                                            onmouseenter="window.modalHandlers['fattura'].deleteBtnEnter(this);" 
                                            onmouseleave="window.modalHandlers['fattura'].deleteBtnLeave(this);">
                                            <div class="pe-0" >
                                                <button class="btn btn-primary w-100">
                                                    <a class=""><?php echo icon('bin.svg','white',15,15); ?></a>
                                                </button>
                                            </div>
                                        </div><?php                       
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="flex-fill ps-4 pe-2 ms-2 me-2 pb-2 pt-3" 
                            onclick="window.modalHandlers['fattura'].addBtnClick();">
                            <button class="btn btn-secondary w-100">AGGIUNGI RIGA</button>
                        </div>
                        <hr class="my-1">
                        <div class="card-body d-flex flex-row">
                            <div class="flex-col w-md-50">
                                <div class="card-body pe-1 pb-0 pt-1"><input id="input_totale_label" class="form-control fs-5" value="TOTALE FATTURA" disabled/></div>
                            </div>
                            <div class="flex-col w-md-50 ms-0">
                                <div class="card-body ps-0 pe-0 pb-0 pt-1"><input type="number" id="sum" class="form-control fs-5" value="<?php echo $sum;?>" disabled/></div>
                            </div>
                        </div>
                    </div>  
                    <div class="flex-col" 
                        <?php 
                            if($_REQUEST['id_fattura']){
                                echo "onclick=\"window.modalHandlers['fattura'].generatePDF(this,{$id_cliente},"._json_encode(['id_fattura'=>$_REQUEST['id_fattura'],'oggetti'=>$oggetti]).")\"";
                            }
                            else{
                                echo "onclick=\"window.modalHandlers['fattura'].generatePDF(this,{$id_cliente},"._json_encode(['oggetti'=>$oggetti]).")\"";
                            }?>
                        >
                        <div class="flex-fill px-3"><button class="btn btn-primary w-100"><a class="me-2"><?php echo icon('print.svg','white',20,20); ?></a>Genera</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php modal_script('fattura'); ?>
