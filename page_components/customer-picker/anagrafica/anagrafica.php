<?php 
    $result=$_REQUEST['id_cliente']?Select('*')->from('clienti')->where("id={$_REQUEST['id_cliente']}")->first():[];
?>
<div class="p-2" id="tab_anagrafica">
    <input type="text" id="id" name="id" value="<?php echo $result['id']??'';?>" hidden/>
    <div class="d-flex flex-row">
        <div class="mb-3 w-35">
            <label for="nominativo" class="form-label">Nominativo</label>
            <input type="text" class="form-control" id="nominativo" name="nominativo" value="<?php echo $result['nominativo']??'';?>" oninput="selectNominativo(event,this)"/>
        </div>
        <div class="mb-3 ms-2">
            <label for="cellulare" class="form-label">cellulare</label>
            <input type="text" class="form-control" id="cellulare" name="cellulare" value="<?php echo $result['cellulare']??'';?>" onchange="cellulareChange();"/>
        </div>
        <div class="mb-3 ms-2">
            <label for="cf" class="form-label">CF/PIVA</label>
            <input type="text" class="form-control" id="cf" name="cf" value="<?php echo $result['cf']??'';?>"/>
        </div>
        <div class="mb-3 ms-2">
            <label for="telefono" class="form-label">Telefono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $result['telefono']??'';?>"/>
        </div>
        <div class="mb-3 ms-2 flex-fill">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" value="<?php echo $result['email']??'';?>"/>
        </div>
    </div>
    <div class="d-flex flex-row">
        <div class="mb-3 flex-fill">
            <label for="indirizzo" class="form-label">Indirizzo</label>
            <input type="text" class="form-control" id="indirizzo" name="indirizzo" value="<?php echo $result['indirizzo']??'';?>"/>
        </div>
        <div class="mb-3 ms-2">
            <label for="cap" class="form-label">CAP</label>
            <input type="text" class="form-control" id="cap" name="cap" value="<?php echo $result['cap']??'';?>"/>
        </div>
        <div class="mb-3 ms-2">
            <label for="citta" class="form-label">Città</label>
            <input type="text" class="form-control" id="citta" name="citta" value="<?php echo $result['citta']??'';?>"/>
        </div>
    </div>
    <div class="d-flex flex-row">
        <div class="mb-3 flex-fill">
            <label for="portato_da" class="form-label">Portato da</label>
            <input type="text" class="form-control" id="portato_da" name="portato_da" value="<?php echo $result['portato_da']??'';?>"/>
        </div>
        <div class="mb-3 ms-2">
            <label for="data_inserimento" class="form-label">Data Inserimento</label>
            <input disabled type="text" class="form-control" id="data_inserimento" name="data_inserimento" value="<?php echo $result['data_inserimento']??now('d/m/Y');?>"/>
        </div>
    </div>
    <div class="d-flex flex-row">
        <div class="mb-3 flex-fill">
            <label for="notizie_cliniche" class="form-label">Notizie cliniche</label>
            <textarea rows="3" class="form-control" id="notizie_cliniche" name="notizie_cliniche" value=""><?php echo $result['notizie_cliniche']??'';?></textarea>
        </div>
    </div>
</div>
<?php  script('page_components/customer-picker/anagrafica/anagrafica.js');?>