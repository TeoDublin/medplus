<?php 
    $view_utenti_presenze=Select('*')->from('view_utenti_presenze')->where("id={$_REQUEST['id']}")->first();
?>

<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Presenze</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="id" value="<?php echo $_REQUEST['id']; ?>" hidden/>
                <div class="mb-3">
                    <label for="username" class="form-label">Utente</label>
                    <input
                        type="text"
                        class="form-control"
                        id="username"
                        value="<?php echo $view_utenti_presenze['username']; ?>"
                        readonly
                        disabled
                    />
                </div>
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input
                        type="text"
                        class="form-control"
                        id="nome"
                        value="<?php echo $view_utenti_presenze['nome']; ?>"
                        readonly
                        disabled
                    />
                </div>
                <div class="mb-3">
                    <label for="data" class="form-label">Giorno</label>
                    <input
                        type="date"
                        class="form-control"
                        name="data"
                        id="data"
                        value="<?php echo $view_utenti_presenze['data']; ?>"
                    />
                </div>
                <div class="mb-3">
                    <label for="orario" class="form-label">Orario</label>
                    <input
                        type="time"
                        class="form-control"
                        name="orario"
                        id="orario"
                        value="<?php echo $view_utenti_presenze['orario']; ?>"
                    />
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['presenze_log'].btnSalva(this)">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php modal_script('presenze_log'); ?>