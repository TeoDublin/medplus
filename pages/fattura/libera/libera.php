<?php style('pages/fattura/libera/libera.css'); ?>
<?php 
    function _clean($txt){
        return trim(preg_replace("#\n\s+#","\n",str_replace("   ","", $txt)));
    }
?>

<div class="p-2 card mt-2">
    <div class="d-flex flex-row">
        <div class="flex-col col-6">
            <div class="mb-1 card-body">
                <label for="head" class="form-label">Intestazione</label>
                <textarea  class="form-control" name="head" rows="8"><?php echo _clean("
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
                <label for="head" class="form-label">Dati</label>
                <textarea  class="form-control" name="dati" rows="8"><?php echo _clean("
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
                <label for="head" class="form-label">Numero e data</label>
                <textarea  class="form-control" name="date" rows="1"><?php echo _clean("Fattura 415 del 03/10/2024");?></textarea>
            </div>
            <div class="mb-1 card-body py-0">
                <label for="head" class="form-label">Piè di pagina</label>
                <textarea  class="form-control" name="footer" rows="4"><?php echo _clean("
                    P.IVA: 06191421210
                    C.F.ZNT DNL 64P58 F839W
                    VIA LEOPARDI N.253
                    80125 NAPOLI");?>
                </textarea>
            </div>
        </div>
    </div>
    <div class="d-flex flex-col card mx-3">
        <div class="card-body d-flex flex-row pb-0">
            <div class="flex-col col-6">
                <div class="card-body pe-1 pb-0 text-center" id="oggetto1"><label class="form-label">OGGETTO</label><input  class="form-control" /></div>
                <div class="card-body pe-1 pb-0 pt-1" id="oggetto2"><input  class="form-control" value="Bollo"/></div>
                <div class="card-body pe-1 pb-0 pt-1" id="oggetto3"><input  class="form-control" value="IMPONIBILE" disabled/></div>
            </div>
            <div class="flex-col col-5 ms-0">
                <div class="card-body ps-0 pe-1 pb-0 text-center" id="importi1">
                    <label class="form-label">IMPORTI</label>
                    <input type="number" class="form-control"/>
                </div>
                <div class="card-body ps-0 pe-1 pb-0 pt-1" id="importi2"><input type="number" class="form-control" value="2.00"/></div>
                <div class="card-body ps-0 pe-1 pb-0 pt-1" id="importi3"><input type="number" class="form-control" value="2.00" disabled/></div>
            </div>
            <div class="flex-col col-1 mx-0">
                <div class="card-body px-0 pb-0 text-center" title="ELIMINA" row="1" onclick="deleteBtnClick(this);" onmouseenter="deleteBtnEnter(this);" onmouseleave="deleteBtnLeave(this);">
                    <label class="form-label">#</label>
                    <div class="pe-0" ><button class="btn btn-primary w-100"><a class="me-2"><?php echo icon('bin.svg','white',15,15) ?></a></button></div>
                </div>
                <div class="card-body px-0 pb-0 pt-1" title="ELIMINA" row="2" onclick="deleteBtnClick(this);" onmouseenter="deleteBtnEnter(this);" onmouseleave="deleteBtnLeave(this);"><button class="btn btn-primary w-100"><a class="me-2"><?php echo icon('bin.svg','white',15,15) ?></a></button></div>
                <div class="card-body px-0 pb-0 pt-1" title="ELIMINA" row="3" onclick="deleteBtnClick(this);" onmouseenter="deleteBtnEnter(this);" onmouseleave="deleteBtnLeave(this);"><button class="btn btn-primary w-100"><a class="me-2"><?php echo icon('bin.svg','white',15,15) ?></a></button></div>
            </div>
        </div>
        <div class="flex-fill ps-4 pe-2 ms-2 me-2 pb-2 pt-3"><button class="btn btn-secondary w-100">SALVA RIGA</button></div>
        <hr class="my-1">
        <div class="card-body d-flex flex-row">
            <div class="flex-col col-6">
                <div class="card-body pe-1 pb-0 pt-1"><input  class="form-control fs-5" value="TOTALE FATTURA" disabled/></div>
            </div>
            <div class="flex-col col-6 ms-0">
                <div class="card-body ps-0 pe-0 pb-0 pt-1"><input type="number" class="form-control fs-5" value="2.00" disabled/></div>
            </div>
        </div>
    </div>  
    <div class="d-flex flex-row">
        <div class="flex-col col-12">
            <div class="mb-1 card-body ">
                <label for="head" class="form-label">Articolo</label>
                <textarea  class="form-control" name="articolo" rows="1"><?php echo _clean("Operazione esente da Iva effettuata ai sensi dell'art. 10, DPR 633/72");?></textarea>
            </div>
        </div>
    </div>
    <div class="flex-col" onclick="generatePDF();">
        <div class="flex-fill px-3"><button class="btn btn-primary w-100"><a class="me-2"><?php echo icon('print.svg','white',20,20) ?></a>Genera</button></div>
    </div>
</div>
<?php script('pages/fattura/libera/libera.js'); ?>
