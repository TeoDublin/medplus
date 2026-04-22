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

    function _index(){
    
        $index=Select('max(`index`) as mx')
            ->from('fatture','f')
            ->inner_join("pagamenti p on f.id = p.id_fattura")
            ->where("YEAR(`data_creazione`) = '".date('Y')."' AND f.id > 1176")
            ->first_or_false();
        
        if(!$index['mx']){
            $index=Select("JSON_EXTRACT(setup, '$.first_index') as first_index")
                ->from('setup')
                ->where("`key`='fatture'")
                ->col('first_index');
        }
        else {
            
            $blocate=Select('max(`index`) as mx')
                ->from('fatture_blocate')
                ->first_or_false();
            
            if($blocate&&(int)$blocate['mx']>(int)$index['mx']){
                $index['mx']=$blocate['mx'];
            }

            $index=(int)$index['mx'] + 1;

        }

        return $index;
    }

    function _percorsi_child(){

        $ret=[];

        foreach($_REQUEST['percorsi'] as $key=>$value){
            $ret=array_merge(
                $ret,
                Select("*,'{$value['view']}' as view")
                    ->from($value['view'])
                    ->where("id={$value['id']}")
                    ->get()
            );
        }
        
        return $ret;
    }

    function _imponibile($percorsi_child){

        $ret=0;

        foreach($percorsi_child ?? [] as $obj){
            $ret+=(double)$obj['prezzo'];
        }

        return $ret;
    }

    $id_cliente = $_REQUEST['data_cliente']['id'];
    $percorsi_child = _percorsi_child();
    $index = _index([]);
    $imponibile = _imponibile($percorsi_child);
    $inps = round( $imponibile *0.04, 2, PHP_ROUND_HALF_UP);
    $bollo = ( $imponibile + $inps ) > 77.47 ? 2:0;
    $totale = $imponibile + $inps + $bollo;
    
?>
<div class="modal bg-dark bg-opacity-50" id="<?= $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >

    <div class="modal-dialog modal-xl">
        <div class="modal-content px-3 text-center">

            <div class="modal-header">
                <h4>Fattura</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?= $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="p-2 card my-2">
                    <div class="pb-0 mb-0 card-body w-100">
                        <div class="d-flex flex-column w-100 my-3">

                            <div class="d-flex flex-row" id="date_div">

                                <div><div class="d-grid justify-content-center align-content-center h-100 mx-2">Fattura n:</div></div>

                                <div class="w-25">
                                    <select class="form-control" id="index" name="index"  value="<?= $index;?>">
                                        <option value="<?= $index;?>" selected><?= $index;?></option>
                                        <?php 
                                            foreach(_deleted_index($index) as $del){
                                                echo "<option value=\"{$del['index']}\">{$del['index']}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>

                                <div><div class="d-grid justify-content-center align-content-center h-100 mx-2">del:</div></div>
                                
                                <div class="w-25"><input type="date" class="form-control" id="data_creazione" name="data_creazione" value="<?= now('Y-m-d'); ?>"/></div>
                                <div><div class="d-grid justify-content-center align-content-center h-100 mx-2">Metodo di Pagamento:</div></div>

                                <div class="flex-fill">
                                    <select class="form-select w-100" value="Pos" name="metodo_pagamento" id="metodo_pagamento">
                                        <option value="Pos">Pos</option>
                                        <option value="Contanti">Contanti</option>
                                        <option value="Bonifico">Bonifico Bancario</option>
                                    </select>                                    
                                </div>                            
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-col card mx-3">

                        <div class="card-body d-flex flex-row pb-0">

                            <div class="flex-col w-md-50 oggetti">

                                <div class="card-body pe-1 pb-0 text-center titleOggetti">
                                    <span class="d-none d-md-block">OGGETTO</span>
                                    <span class="d-md-none">OG.</span>
                                </div>
                                <div class="card-body pe-1 pb-0 pt-1 oggetto" id="row1"><input id="oggetto1" class="form-control" value="Interventi/sedute di fisioterapia"/></div>
                                <div class="card-body pe-1 pb-0 pt-1"><input  class="form-control" value="Rivalsa INPS" disabled/></div>
                                <div class="card-body pe-1 pb-0 pt-1"><input  class="form-control" value="Bollo" disabled/></div>
                            </div>

                            <div class="flex-col w-md-41 ms-0 importi">

                                <div class="card-body ps-0 pe-1 pb-0 text-center titleImporti">
                                    <span class="d-none d-md-block">IMPORTI</span>
                                    <span class="d-md-none">IMP.</span>
                                </div>

                                <div class="card-body ps-0 pe-1 pb-0 pt-1 importo importo_row" id="row1"><input type="number" id="importo1" class="form-control" value="<?= $imponibile; ?>"></div>
                                <div class="card-body ps-0 pe-1 pb-0 pt-1"><input type="number" id="inps" class="form-control" value="<?= $inps; ?>" disabled/></div>
                                <div class="card-body ps-0 pe-1 pb-0 pt-1"><input type="number" id="bollo" class="form-control" value="<?= $bollo; ?>" disabled/></div>

                            </div>

                            <div class="flex-col w-md-10 ms-0 btns">
                                
                                <div class="card-body ps-0 pe-1 pb-0 text-center w-10"><span class="">#</span></div>
                                <div class="card-body ps-0 pe-1 pb-0 pt-1 delBtn" title="ELIMINA"  id="row1"
                                    onclick="window.modalHandlers['fattura'].deleteBtnClick(this);" 
                                    onmouseenter="window.modalHandlers['fattura'].deleteBtnEnter(this);" 
                                    onmouseleave="window.modalHandlers['fattura'].deleteBtnLeave(this);">
                                    <div class="pe-0" >
                                        <button class="btn btn-primary w-100">
                                            <a class=""><?= icon('bin.svg','white',15,15); ?></a>
                                        </button>
                                    </div>
                                </div>
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
                                <div class="card-body ps-0 pe-0 pb-0 pt-1"><input type="number" id="sum" class="form-control fs-5" value="<?= $totale;?>" disabled/></div>
                            </div>
                        </div>

                    </div>  
                    <div class="flex-col mt-3" onclick="window.modalHandlers['fattura'].generatePDF(this)">
                        <div class="flex-fill px-3">
                            <button class="btn btn-primary w-100 mb-2"><a class="me-2"><?= icon('print.svg','white',20,20); ?></a>Genera</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php modal_script('fattura'); ?>
