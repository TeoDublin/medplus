<?php 
    function _view_utenti(){
        return $_REQUEST['id_utente']?Select('*')->from('view_utenti')->where("id={$_REQUEST['id_utente']}")->first():false;
    }
    $view_utenti=_view_utenti();
?>
<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Utenti</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="id_utente" value="<?php echo $view_utenti?$view_utenti['id']:'';?>" hidden/>
                <div class="p-2">
                    <label class="form-label" for="nome">Nome</label>
                    <input class="form-control" type="text" name="nome" value="<?php echo $view_utenti?$view_utenti['nome']:'';?>"/>
                </div>
                <div class="p-2">
                    <label class="form-label" for="user">Utente</label>
                    <input class="form-control" type="text" name="user" value="<?php echo $view_utenti?$view_utenti['user']:'';?>"/>
                </div>
                <div class="p-2">
                    <label class="form-label" for="id_ruolo">Ruolo</label>
                    <select class="form-control" name="id_ruolo" value="<?php echo $view_utenti?$view_utenti['id_ruolo']:'';?>">
                        <?php 
                            foreach(Select('*')->from('ruoli')->get() as $ruolo){
                                echo "<option value=\"{$ruolo['id']}\" ".($view_utenti['id_ruolo']&&$ruolo['id']==$view_utenti['id_ruolo']?'selected':'').">{$ruolo['ruolo']}</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['utenti'].btnSalva(this)">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('utenti'); ?>