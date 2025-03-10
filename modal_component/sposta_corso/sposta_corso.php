<?php 
    function _attr_data($id_corso){
        return "data-id-corso=\"{$id_corso}\"";
    }
    $row=$_REQUEST['row']??$_REQUEST['row_inizio'];
    $id_corso=$_REQUEST['id_corso']??$_REQUEST['id'];
?>
<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Sposta Corso</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php 
                    $result=$id_corso?Select('*')->from('corsi_planning')->where("id={$id_corso}")->first():[];
                    if(empty($result)){
                        $planning=Select('*')->from('view_planning')->where("id_terapista={$_REQUEST['id_terapista']} and data='{$_REQUEST['data']}'")->get();
                    }
                    else{
                        $planning=Select('*')->from('view_planning')->where("id_terapista={$_REQUEST['id_terapista']} and data='{$_REQUEST['data']}' and id<> {$result['id']}")->get();
                    }
                    $planning_busy=[];
                    foreach ($planning as $plan) {
                        for($i=$plan['row_inizio'];$i<=$plan['row_fine'];$i++){
                            array_push($planning_busy,$i);
                        }
                    }
                    $rows=Select("id,TIME_FORMAT(ora, '%H:%i') as ora")->from('planning_row')->get();
                ?>
                <div class="p-2">
                    <div class="mb-3">
                        <label for="terapista" class="form-label">Terapista</label>
                        <select type="text"  name="id_terapista" <?php echo _attr_data($id_corso);?> class="form-control text-center" value="<?php echo $_REQUEST['id_terapista']??'';?>" 
                            onchange="window.modalHandlers['sposta_corso'].change(this)">
                            <?php 
                                foreach(Select('*')->from('terapisti')->get() as $value){
                                    $selected = (isset($_REQUEST['id_terapista']) && $_REQUEST['id_terapista'] == $value['id']) ? 'selected' : '';
                                    echo "<option value=\"{$value['id']}\" class=\"ps-4  bg-white\" {$selected}>{$value['terapista']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="data" class="form-label">Data</label>
                        <input type="date" class="form-control text-center" name="data" value="<?php echo $_REQUEST['data']; ?>" <?php echo _attr_data($id_corso);?> 
                            onchange="window.modalHandlers['sposta_corso'].change(this)"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="row_inizio" class="form-label">Inizio</label>
                        <select type="text" class="form-control" id="row_inizio" name="row_inizio" value="<?php echo $result['row_inizio']??'';?>">
                            <?php 
                                foreach($rows as $value){
                                    if(!in_array($value['id'],$planning_busy)&&(!empty($result)||$value['id']>=$row)){
                                        if(empty($result)) $selected = $value['id']==$row ? 'selected' : '';
                                        else $selected = (isset($result['row_inizio']) && $result['row_inizio'] == $value['id']) ? 'selected' : '';
                                        echo "<option value=\"{$value['id']}\" class=\"ps-4  bg-white\" {$selected}>{$value['ora']}</option>";
                                    }
                                    else echo "<option value=\"{$value['id']}\" class=\"ps-4  bg-dark\" disabled>{$value['ora']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="row_fine" class="form-label">Fine</label>
                        <select type="text" class="form-control" id="row_fine" name="row_fine" value="<?php echo $result['row_fine']??'';?>">
                            <?php 
                                foreach($rows as $value){
                                    if(!in_array($value['id'],$planning_busy)&&(!empty($result)||$value['id']>=$row)){                                        
                                        if(empty($result)) $selected = $value['id']==$row ? 'selected' : '';
                                        else $selected = (isset($result['row_fine']) && $result['row_fine'] == $value['id']) ? 'selected' : '';
                                        echo "<option value=\"{$value['id']}\" class=\"ps-4  bg-white\" {$selected}>{$value['ora']}</option>";
                                    }
                                    else echo "<option value=\"{$value['id']}\" class=\"ps-4  bg-dark\" disabled>{$value['ora']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-tertiary" <?php echo _attr_data($id_corso);?>onclick="window.modalHandlers['sposta_corso'].btnDelete(this)"
                >Elimina</a>
                <a href="#" class="btn btn-primary" <?php echo _attr_data($id_corso);?>onclick="window.modalHandlers['sposta_corso'].btnSalva(this)"
                >Salva</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('sposta_corso'); ?>