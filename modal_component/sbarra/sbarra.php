<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Sbarra</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php 
                    $result=$_REQUEST['planning_motivi_id']?Select('*')->from('planning_motivi')->where("id={$_REQUEST['planning_motivi_id']}")->first():[];
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
                <input type="text" name="id" value="<?php echo $_REQUEST['planning_motivi_id']??'';?>" hidden/>
                <input type="text" name="id_terapista" value="<?php echo $_REQUEST['id_terapista']??'';?>" hidden/>
                <input type="text" name="data" value="<?php echo $_REQUEST['data'];?>" hidden/>
                <div class="p-2">
                    <div class="mb-3">
                        <label for="row_inizio" class="form-label">Inizio</label>
                        <select type="text" class="form-control" id="row_inizio" name="row_inizio" value="<?php echo $result['row_inizio']??'';?>">
                            <?php 
                                foreach($rows as $value){
                                    if(!in_array($value['id'],$planning_busy)&&(!empty($result)||$value['id']>=$_REQUEST['row'])){
                                        if(empty($result)) $selected = $value['id']==$_REQUEST['row'] ? 'selected' : '';
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
                                    if(!in_array($value['id'],$planning_busy)&&(!empty($result)||$value['id']>=$_REQUEST['row'])){                                        
                                        if(empty($result)) $selected = $value['id']==$_REQUEST['row'] ? 'selected' : '';
                                        else $selected = (isset($result['row_fine']) && $result['row_fine'] == $value['id']) ? 'selected' : '';
                                        echo "<option value=\"{$value['id']}\" class=\"ps-4  bg-white\" {$selected}>{$value['ora']}</option>";
                                    }
                                    else echo "<option value=\"{$value['id']}\" class=\"ps-4  bg-dark\" disabled>{$value['ora']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="id_motivo" class="form-label">Motivo</label>
                        <select type="text" class="form-control" id="id_motivo" name="id_motivo" value="<?php echo $result['id_motivo']??'';?>">
                            <?php 
                                foreach(Select('*')->from('motivi')->get() as $value){
                                    $selected = (isset($result['id_motivo']) && $result['id_motivo'] == $value['id']) ? 'selected' : '';
                                    echo "<option value=\"{$value['id']}\" class=\"ps-4  bg-white\" {$selected}>{$value['motivo']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php if(!empty($result)) {
                    echo "<a href=\"#\" data-bs-dismiss=\"modal\" class=\"btn btn-tertiary\" onclick=\"window.modalHandlers['sbarra'].btnElimina({$result['id']})\">Elimina</a>";
                }?>
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['sbarra'].btnSalva(this)">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('sbarra'); ?>