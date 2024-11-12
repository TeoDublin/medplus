<?php 
    $result=Select('*planning*,*terapisti*,*clienti*')
        ->from('planning','p')
        ->left_join('terapisti t on p.id_terapista = t.id')
        ->left_join('clienti c on p.id_cliente = c.id')
        ->where("p.row={$_REQUEST['row']} and p.id_terapista = {$_REQUEST['id_terapista']} and p.data='".format_date($_REQUEST['data'])."'")
        ->first_or_false();
        var_dump($result);
?>
<div class="p-2">
    <input type="text" id="id" name="id" value="" hidden/>
    <div class="d-flex flex-row">
        <div class="mb-3 w-35">
            <label for="nominativo" class="form-label">Nominativo</label>
            <input type="text" class="form-control" id="nominativo" name="nominativo" value="<?php echo $result['nominativo']??'';?>" oninput="selectNominativo(event,this)"/>
        </div>
        <?php component('trattamenti-list','php'); ?>
        <div class="mb-3 ms-2">
            <label for="celulare" class="form-label">Celulare</label>
            <input type="text" class="form-control" id="celulare" name="celulare" value="<?php echo $result['celulare']??'';?>">
        </div>
        <div class="mb-3 ms-2">
            <label for="cf" class="form-label">CF/PIVA</label>
            <input type="text" class="form-control" id="cf" name="cf" value="<?php echo $result['cf']??'';?>">
        </div>
        <div class="mb-3 ms-2">
            <label for="telefono" class="form-label">Telefono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $result['telefono']??'';?>">
        </div>
        <div class="mb-3 ms-2">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" value="<?php echo $result['email']??'';?>">
        </div>                        
    </div>               
    <div class="d-flex flex-row">
        <div class="mb-3 flex-fill">
            <label for="indirizzo" class="form-label">Indirizzo</label>
            <input type="text" class="form-control" id="indirizzo" name="indirizzo" value="<?php echo $result['indirizzo']??'';?>">
        </div>
        <div class="mb-3 ms-2">
            <label for="cap" class="form-label">CAP</label>
            <input type="text" class="form-control" id="cap" name="cap" value="<?php echo $result['cap']??'';?>">
        </div>
        <div class="mb-3 ms-2">
            <label for="citta" class="form-label">Città</label>
            <input type="text" class="form-control" id="citta" name="citta" value="<?php echo $result['citta']??'';?>">
        </div>
        <div class="mb-3 ms-2">
            <label for="tipo" class="form-label">Tipo</label>
            <select type="text" class="form-control" id="tipo" name="tipo" value="<?php echo $result['tipo']??'';?>">
                <?php 
                    foreach(Enum('clienti','tipo')->list as $value){
                        echo "<option>{$value}</option>";
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="d-flex flex-row">
        <div class="mb-3">
            <label for="portato_da" class="form-label">Portato da</label>
            <input type="text" class="form-control" id="portato_da" name="portato_da" value="<?php echo $result['portato_da']??'';?>">
        </div>
        <div class="mb-3 ms-2">
            <label for="data_inserimento" class="form-label">Data Inserimento</label>
            <input disabled type="text" class="form-control" id="data_inserimento" name="data_inserimento" value="<?php echo $result['data_inserimento']??now('d/m/Y');?>">
        </div>
        <div class="mb-3 ms-2 flex-fill">
            <label for="prestazioni_precedenti" class="form-label">Prestazioni precedenti</label>
            <input type="text" class="form-control" id="prestazioni_precedenti" name="prestazioni_precedenti" value="<?php echo $result['prestazioni_precedenti']??'';?>">
        </div>
    </div>
    <div class="d-flex flex-row">
        <div class="mb-3 flex-fill">
            <label for="notizie_cliniche" class="form-label">Notizie cliniche</label>
            <textarea rows="3" class="form-control" id="notizie_cliniche" name="notizie_cliniche" value=""><?php echo $result['notizie_cliniche']??'';?></textarea>
        </div>
        <div class="mb-3 ms-2 w-50">
            <label for="note_trattamento" class="form-label">Note trattamento</label>
            <textarea rows="3" class="form-control" id="note_trattamento" name="note_trattamento" value=""><?php echo $result['note_trattamento']??'';?></textarea>
        </div>   
    </div>
</div>