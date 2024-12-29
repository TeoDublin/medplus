<?php style('modal_component/fattura/fattura.css'); ?>
<?php 
    function _clean($txt){
        return trim(preg_replace("#\n\s+#","\n",str_replace("   ","", $txt)));
    }
    function _index(){
        $index=Select('max(`index`) as mx')->from('fatture')->first_or_false();
        if(!$index['mx'])$index=Select("JSON_EXTRACT(setup, '$.first_index') as first_index")->from('setup')->where("`key`='fatture'")->col('first_index');
        else $index=(int)$index['mx']+1;
        return $index; 
    }
    $index=_index();
?>
<div class="modal bg-dark bg-opacity-50" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content px-3 text-center">
            <div class="modal-header">
                <h4>Prenota</h4>
                <button type="button" class="btn-resize" aria-hidden="true" onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="p-2 card mt-2">
                    <div class="d-flex flex-row">
                        <div class="flex-col col-6">
                            <div class="mb-1 card-body">
                                <label for="head" class="form-label">Intestazione</label>
                                <textarea  class="form-control" id="head" name="head" rows="8"><?php echo _clean("
                                        Daniela Zanotti
                                        Dr. in Fisioterapia
                                        Specialista in Terapia Manuale
                                        Fisioterapista ISICO NAPOLI
                                        Iscrizione Albo Nr.936
                                        Tel 08119918966
                                        Email: danielazanotti@hotmail.it
                                        Iban: IT82M0301503200000002984154");?>
                                </textarea>
                            </div>
                        </div>
                        <div class="flex-col col-3">
                            <div class="mb-1 card-body">
                                <label for="dati" class="form-label">Dati</label>
                                <textarea  class="form-control" id="dati" name="dati" rows="8"><?php echo _clean("
                                    Spett.le
                                    Aprea Ettore
                                    via F. Gaelota 23
                                    80125
                                    Napoli
                                    CF o P.Iva PRATTR39B27L259S");?>
                                </textarea>
                            </div>
                            
                        </div>
                        <div class="flex-col col-3">
                            <div class="mb-1 card-body pb-4">
                                <label for="date" class="form-label">Numero e data</label>
                                <textarea  class="form-control" id="date" name="date" rows="1"><?php echo _clean("Fattura n: {$index} del ".now('d/m/Y'));?></textarea>
                            </div>
                            <div class="mb-1 card-body py-0">
                                <label for="footer" class="form-label">Piè di pagina</label>
                                <textarea  class="form-control" id="footer" name="footer" rows="4"><?php echo _clean("
                                    P.IVA: 06191421210
                                    C.F.ZNT DNL 64P58 F839W
                                    VIA LEOPARDI N.253
                                    80125 NAPOLI");?>
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-col card mx-3" body>
                        <div class="card-body d-flex flex-row pb-0">
                            <div class="flex-col col-6 oggetti">
                                <div class="card-body pe-1 pb-0 text-center"><span>OGGETTO</span></div>
                                <div class="card-body pe-1 pb-0 pt-1 oggetto" id="row1"><input id="oggetto1" class="form-control" value=""/></div>
                                <div class="card-body pe-1 pb-0 pt-1" id=""><input id="oggettoBollo" class="form-control stampDisabled" value="Bollo"/></div>
                                <div class="card-body pe-1 pb-0 pt-1"><input  class="form-control" id="oggetto_imponibile" value="IMPONIBILE" disabled/></div>
                            </div>
                            <div class="flex-col col-5 ms-0 importi">
                                <div class="card-body ps-0 pe-1 pb-0 text-center"><span class="">IMPORTI</span></div>
                                <div class="card-body ps-0 pe-1 pb-0 pt-1 importo importo_row" id="row1"><input type="number" id="importo1" class="form-control" value="" 
                                    onchange="window.modalHandlers['fattura'].addTotal(this)"/>
                                </div>
                                <div class="card-body ps-0 pe-1 pb-0 pt-1" id="bollo"><input type="number" id="importoBollo" class="form-control stampDisabled" value="2.0"/></div>
                                <div class="card-body ps-0 pe-1 pb-0 pt-1"><input type="number" id="imponibile" class="form-control" value="" disabled/></div>
                            </div>
                            <div class="flex-col col-1 mx-0 btns">
                                <div class="card-body ps-0 pe-1 pb-0 text-center"><span class="">AZIONI</span></div>
                                <div class="card-body ps-0 pe-1 pb-0 pt-1 delBtn" title="ELIMINA"  id="row1" 
                                    onclick="window.modalHandlers['fattura'].deleteBtnClick(this);" 
                                    onmouseenter="window.modalHandlers['fattura'].deleteBtnEnter(this);" 
                                    onmouseleave="window.modalHandlers['fattura'].deleteBtnLeave(this);">
                                    <div class="pe-0" ><button class="btn btn-primary w-100"><a class="me-2"><?php echo icon('bin.svg','white',15,15); ?></a></button></div>
                                </div>
                                <div class="card-body ps-0 pe-1 pb-0 pt-1 delBtn" title="ELIMINA MARCA DA BOLLO" id="bollo" 
                                    onclick="window.modalHandlers['fattura'].stampBtnClick(this);" 
                                    onmouseenter="window.modalHandlers['fattura'].stampBtnEnter(this);" 
                                    onmouseleave="window.modalHandlers['fattura'].stampBtnLeave(this);">
                                    <div class="pe-0">
                                        <div class="form-check form-switch ">
                                            <input class="form-check-input pe-4 btn-dark" type="checkbox" role="switch" id="btnBollo">
                                        </div>
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
                            <div class="flex-col col-6">
                                <div class="card-body pe-1 pb-0 pt-1"><input id="input_totale_label" class="form-control fs-5" value="TOTALE FATTURA" disabled/></div>
                            </div>
                            <div class="flex-col col-6 ms-0">
                                <div class="card-body ps-0 pe-0 pb-0 pt-1"><input type="number" id="totale" class="form-control fs-5" value="" disabled/></div>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-row pt-0" id="spanBollo">
                            <div class="flex-col col-12">
                                <div class="card-body pe-1 pb-0 pt-1 mt-0"><input id="spanBolloValue" class="form-control" value="Marca da bollo su originale di € 2,00 per importi superiori ad € 77,47"/></div>
                            </div>
                        </div>
                    </div>  
                    <div class="d-flex flex-row" articolo>
                        <div class="flex-col col-12">
                            <div class="mb-1 card-body ">
                                <label for="articolo" class="form-label">Articolo</label>
                                <textarea  class="form-control" id="articolo" name="articolo" rows="1"><?php echo _clean("Operazione esente da Iva effettuata ai sensi dell'art. 10, DPR 633/72");?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="flex-col" 
                        onclick="window.modalHandlers['fattura'].generatePDF(<?php echo "{$_REQUEST['id_percorso']},{$index},{$_REQUEST['id_cliente']}";?>);">
                        <div class="flex-fill px-3"><button class="btn btn-primary w-100"><a class="me-2"><?php echo icon('print.svg','white',20,20); ?></a>Genera</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php modal_script('fattura'); ?>
