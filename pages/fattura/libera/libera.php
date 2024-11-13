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
                <label for="head" class="form-label">Dati</label>
                <textarea  class="form-control" id="head" name="head" rows="8"><?php echo _clean("
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
                <textarea  class="form-control" id="head" name="head" rows="1"><?php echo _clean("Fattura 415 del 03/10/2024");?></textarea>
            </div>
            <div class="mb-1 card-body py-0">
                <label for="head" class="form-label">Piè di pagina</label>
                <textarea  class="form-control" id="head" name="head" rows="4"><?php echo _clean("
                    P.IVA: 06191421210
                    C.F.ZNT DNL 64P58 F839W
                    VIA LEOPARDI N.253
                    80125 NAPOLI");?>
                </textarea>
            </div>
        </div>
    </div>
    <div class="d-flex flex-row">
        <div class="flex-col col-11">
            <div class="mb-1 card-body pt-0">
                <label for="head" class="form-label">Articolo</label>
                <textarea  class="form-control" id="head" name="head" rows="1"><?php echo _clean("Operazione esente da Iva effettuata ai sensi dell'art. 10, DPR 633/72");?></textarea>
            </div>
        </div>
        <div class="flex-col col-1" onclick="generatePDF();">
            <div class="mb-1 card-body pt-4 px-0 mt-2">
                <button class="btn btn-primary" id="print"><a class="me-2"><?php echo icon('print.svg','white',20,20) ?></a>Genera</button>
            </div>
        </div>
    </div>
</div>
<script>
    function generatePDF() {
        $.post('post/fattura_libera.php').done(response => {
            const link = document.createElement('a');
            link.href = response; 
            link.target = '_blank'; 
            link.click();
        });
    }
</script>

</body>
</html>
