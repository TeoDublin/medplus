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
                    <label class="form-label" for="user">email</label>
                    <input class="form-control" type="text" name="email" value="<?php echo $view_utenti?$view_utenti['email']:'';?>"/>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['utenti'].btnSalva(this)">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('utenti'); ?>