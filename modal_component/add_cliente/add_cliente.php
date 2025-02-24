<?php
    $result=$_REQUEST['id_cliente']?Select('*')->from('clienti')->where("id={$_REQUEST['id_cliente']}")->first_or_false():false;
?>
<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Aggiungi Cliente</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-row">
                    <input name="id" value="<?php echo $_REQUEST['id_cliente']??'';?>" hidden/>
                    <div class="p-1 flex-fill">
                        <label for="nominativo" class="form-label">Nominativo</label>
                        <input type="text" name="nominativo" class="form-control" value="<?php echo $result['nominativo']??'';?>"/>
                    </div>
                    <div class="p-1 w-15">
                        <label for="cellulare" class="form-label">Cellulare</label>
                        <input type="number" name="cellulare" class="form-control" value="<?php echo $result['cellulare']??'';?>"/>
                    </div>
                    <div class="p-1 w-15">
                        <label for="telefono" class="form-label">Telefono</label>
                        <input type="number" name="telefono" class="form-control" value="<?php echo $result['telefono']??'';?>"/>
                    </div>
                </div>
                <div class="d-flex flex-row">
                    <div class="p-1 flex-fill">
                        <label for="indirizzo" class="form-label">Indirizzo</label>
                        <input type="text" name="indirizzo" class="form-control" value="<?php echo $result['indirizzo']??'';?>"/>
                    </div>
                    <div class="p-1 w-30">
                        <label for="citta" class="form-label">Citta</label>
                        <input type="text" name="citta" class="form-control" value="<?php echo $result['citta']??'';?>"/>
                    </div>
                    <div class="p-1 w-10">
                        <label for="cap" class="form-label">Cap</label>
                        <input type="number" name="cap" class="form-control" value="<?php echo $result['cap']??'';?>"/>
                    </div>                    
                </div>
                <div class="d-flex flex-row">
                    <div class="p-1 w-30">
                        <label for="cf" class="form-label">CF</label>
                        <input type="text" name="cf" class="form-control" value="<?php echo $result['cf']??'';?>"/>
                    </div>
                    <div class="p-1 w-30">
                        <label for="portato_da" class="form-label">Portato da</label>
                        <select type="text" class="form-control text-center" name="portato_da" value="<?php echo $result['portato_da']??'';?>">
                            <option value="" class="ps-4  bg-white">Nessuno</option><?php 
                            foreach(Select('*')->from('terapisti')->get() as $value){
                                $selected = (isset($result['portato_da']) && $result['portato_da'] == $value['id']) ? 'selected' : '';
                                echo "<option value=\"{$value['id']}\" class=\"ps-4  bg-white\" {$selected}>{$value['terapista']}</option>";
                            }?>
                        </select>
                    </div>
                    <div class="p-1 flex-fill">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" value="<?php echo $result['email']??'';?>"/>
                    </div>
                </div>
                <div class="d-flex flex-row">
                    <div class="p-1 flex-fill">
                        <label for="notizie_cliniche" class="form-label">Notizie Cliniche</label>
                        <textarea name="notizie_cliniche" class="form-control" rows="4"><?php echo trim($result['notizie_cliniche']) ?? ''; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['add_cliente'].btnSalva(this)">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('add_cliente'); ?>