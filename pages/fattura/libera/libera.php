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
                <div class="card-body pe-1 pb-0">
                    <label class="form-label">OGGETTO</label>
                    <input  class="form-control" />
                </div>
                <div class="card-body pe-1 pb-0 pt-1"><input  class="form-control" value="Bollo"/></div>
                <div class="card-body pe-1 pb-0 pt-1"><input  class="form-control" value="IMPONIBILE" disabled/></div>
            </div>
            <div class="flex-col col-6 ms-0">
                <div class="card-body ps-0 pb-0">
                    <label class="form-label">IMPORTI</label>
                    <input type="number" class="form-control"/>
                </div>
                <div class="card-body ps-0 pb-0 pt-1"><input type="number" class="form-control" value="2.00"/></div>
                <div class="card-body ps-0 pb-0 pt-1"><input type="number" class="form-control" value="2.00" disabled/></div>
            </div>
        </div>
        <div class="flex-fill px-4 mx-2 pb-2 pt-3"><button class="btn btn-primary w-100">AGGIUNGI RIGA</button></div>
        <hr class="my-1">
        <div class="card-body d-flex flex-row">
            <div class="flex-col col-6">
                <div class="card-body pe-1 pb-0 pt-1"><input  class="form-control fs-5" value="TOTALE FATTURA" disabled/></div>
            </div>
            <div class="flex-col col-6 ms-0">
                <div class="card-body ps-0 pb-0 pt-1"><input type="number" class="form-control fs-5" value="2.00" disabled/></div>
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
<script>
    function generatePDF() {
        let _data = {};
        document.querySelectorAll('textarea[name]').forEach(element =>{ _data[element.getAttribute('name')]=element.textContent });
        $.post('post/fattura_libera.php',_data).done(response => {
            const link = document.createElement('a');
            link.href = response; 
            link.target = '_blank'; 
            link.click();
        });
    }
</script>

</body>
</html>
