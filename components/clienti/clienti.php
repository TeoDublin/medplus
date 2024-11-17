<?php $params=$_REQUEST['id']?Select('*')->from('clienti','c')->where("c.id={$_REQUEST['id']}")->first_or_false():false;?>
<div class="p-2">
    <input type="text" id="id" name="id" value="<?php echo $params['id']??'';?>" hidden/>
    <div class="d-flex flex-row">
        <div class="mb-3 w-35">
            <label for="nominativo" class="form-label">Nominativo</label>
            <input type="text" class="form-control" id="nominativo" name="nominativo" value="<?php echo $params['nominativo']??'';?>"/>
        </div>
        <div class="mb-3 ms-2">
            <label for="cellulare" class="form-label">cellulare</label>
            <input type="text" class="form-control" id="cellulare" name="cellulare" value="<?php echo $params['cellulare']??'';?>">
        </div>
        <div class="mb-3 ms-2">
            <label for="cf" class="form-label">CF/PIVA</label>
            <input type="text" class="form-control" id="cf" name="cf" value="<?php echo $params['cf']??'';?>">
        </div>
        <div class="mb-3 ms-2">
            <label for="telefono" class="form-label">Telefono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $params['telefono']??'';?>">
        </div>
        <div class="mb-3 ms-2">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" value="<?php echo $params['email']??'';?>">
        </div>                        
    </div>               
    <div class="d-flex flex-row">
        <div class="mb-3 flex-fill">
            <label for="indirizzo" class="form-label">Indirizzo</label>
            <input type="text" class="form-control" id="indirizzo" name="indirizzo" value="<?php echo $params['indirizzo']??'';?>">
        </div>
        <div class="mb-3 ms-2">
            <label for="cap" class="form-label">CAP</label>
            <input type="text" class="form-control" id="cap" name="cap" value="<?php echo $params['cap']??'';?>">
        </div>
        <div class="mb-3 ms-2">
            <label for="citta" class="form-label">Città</label>
            <input type="text" class="form-control" id="citta" name="citta" value="<?php echo $params['citta']??'';?>">
        </div>
        <div class="mb-3 ms-2">
            <label for="tipo" class="form-label">Tipo</label>
            <select type="text" class="form-control" id="tipo" name="tipo" value="<?php echo $params['tipo']??'';?>">
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
            <input type="text" class="form-control" id="portato_da" name="portato_da" value="<?php echo $params['portato_da']??'';?>">
        </div>
        <div class="mb-3 ms-2">
            <label for="data_inserimento" class="form-label">Data Inserimento</label>
            <input disabled type="text" class="form-control" id="data_inserimento" name="data_inserimento" value="<?php echo $params['data_inserimento']??now('d/m/Y');?>">
        </div>
        <div class="mb-3 ms-2 flex-fill">
            <label for="prestazioni_precedenti" class="form-label">Prestazioni precedenti</label>
            <input type="text" class="form-control" id="prestazioni_precedenti" name="prestazioni_precedenti" value="<?php echo $params['prestazioni_precedenti']??'';?>">
        </div>
    </div>
    <div class="d-flex flex-row">
        <div class="mb-3 flex-fill">
            <label for="notizie_cliniche" class="form-label">Notizie cliniche</label>
            <textarea rows="3" class="form-control" id="notizie_cliniche" name="notizie_cliniche" value=""><?php echo $params['notizie_cliniche']??'';?></textarea>
        </div>
        <div class="mb-3 ms-2 w-50">
            <label for="note_trattamento" class="form-label">Note trattamento</label>
            <textarea rows="3" class="form-control" id="note_trattamento" name="note_trattamento" value=""><?php echo $params['note_trattamento']??'';?></textarea>
        </div>   
    </div>
</div>