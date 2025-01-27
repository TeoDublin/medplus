<?php style('modal_component/corsi_elenco/corsi_elenco.css');?>
<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Aggiungi corso</h4>
                <button type="button" class="btn-resize" aria-hidden="true" onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto flex-grow-1">
                <?php 
                    $corso=$_REQUEST['id']?Select('*')->from('view_corsi')->where("id={$_REQUEST['id']}")->first():[];
                    $giorni=$_REQUEST['id']?Select('*')->from('corsi_giorni')->where("id_corso={$_REQUEST['id']}")->get():[];
                ?>
                <div class="p-2">
                    <input name="id" value="<?php echo $_REQUEST['id']??'';?>" hidden/>
                    <div class="d-flex flex-row mb-2">
                        <div class="flex-fill">
                            <label for="id_categoria" class="form-label">Categoria</label><?php 
                            echo "<select class=\"form-control text-center\" name=\"id_categoria\" value=\"{$corso['id_categoria']}\">";
                                foreach(Select('*')->from('corsi_categorie')->get() as $enum){
                                    $selected=$corso['id_categoria']==$enum['id']?'selected':'';
                                    echo "<option value=\"{$enum['id']}\" {$selected}>{$enum['categoria']}</option>";
                                }
                            echo "</select>";?>
                        </div>
                        <div class="ms-2 w-30">
                            <label for="scadenza" class="form-label" >Scadenza Ogni</label>
                            <input type="number" class="form-control text-center" name="scadenza" value="<?php echo $corso['scadenza']??''; ?>"/> 
                        </div>
                    </div>
                    <div class="d-flex flex-row mb-2">
                        <div class="flex-fill">
                            <label for="corso" class="form-label" >Corso</label>
                            <input type="text" class="form-control text-center" name="corso" value="<?php echo $corso['corso']??''; ?>"/> 
                        </div>
                        <div class="ms-2 w-30">
                            <label for="prezzo" class="form-label" >Prezzo</label>
                            <input type="number" class="form-control text-center" name="prezzo" value="<?php echo $corso['prezzo']??''; ?>"/> 
                        </div>
                    </div>
                    <div class="w-100">
                        <div class="card">
                            <div class="card-header ">
                                <h5>Giorni</h5>
                            </div>
                            <div class="card-body p-1">
                                <div class="container-fluid text-center">
                                    <div class="table-responsive mb-2 title">
                                        <div class="d-flex flex-row w-100">
                                            <div class="flex-fill"><span>Giorno</span></div>
                                            <div class="w-30 mx-2"><span>Orario</span></div>
                                            <div class="w-10"><span>#</span></div>
                                        </div>
                                    </div>
                                    <div class="table-responsive" id="table-body"><?php 
                                        if($giorni){?>
                                            <?php
                                                $is_first=true;
                                                foreach($giorni as $giorno){
                                                    $_REQUEST['giorno']=$giorno['giorno'];
                                                    $_REQUEST['ora']=$giorno['ora'];
                                                    if($is_first){
                                                        $is_first=false;
                                                        $mt='';
                                                    }
                                                    else $mt='mt-2';
                                                    echo "<div class=\"d-flex flex-row w-100 giorno_row {$mt}\">";
                                                        require __DIR__ . '/../../post/aggiungi_giorno.php';
                                                    echo "</div>";
                                                }
                                                ?>
                                            <?php
                                        }
                                        else{
                                            echo "<div class=\"d-flex flex-row w-100 giorno_row {$mt}\">";
                                                require __DIR__ . '/../../post/aggiungi_giorno.php';
                                            echo "</div>";
                                        }?>
                                    </div>
                                    <div class="my-3">
                                        <button class="btn btn-primary w-100" onclick="window.modalHandlers['corsi_elenco'].aggiungiGiorno(this)">AGGIUNGI GIORNO</button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['corsi_elenco'].btnSalva(this)">Salva</a>
            </div>
        </div>
    </div>
    <?php modal_script('corsi_elenco'); ?>
</div>