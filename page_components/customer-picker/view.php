<div class="modal bg-dark bg-opacity-50 modal-xxl modal-xl" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Prenota</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="container"></div>
            <div class="modal-body" id="modal_body_prenota">
                <div class="d-flex w-100 py-3">
                    <div class="flex-fill flex-column">
                        <ul class="nav nav-tabs">
                            <div class="nav-item tab anagrafica">
                                <div class="nav-link <?php echo _tab('anagrafica')?'active':'';?>" aria-current="page" target="<?php echo "page_component.php?&tab=anagrafica&id_terapista={$_REQUEST['id_terapista']}&data={$_REQUEST['data']}"; ?>" onclick="_tab(this);">Anagrafica</div>
                            </div>
                            <div class="nav-item tab" hidden>
                                <div class="nav-link <?php echo _tab('trattamenti')?'active':'';?>" aria-current="page" target="<?php echo "page_component.php?&tab=trattamenti&id_terapista={$_REQUEST['id_terapista']}&data={$_REQUEST['data']}"; ?>" onclick="_tab(this);">Trattamenti</div>
                            </div>
                            <div class="nav-item tab" hidden>
                                <div class="nav-link <?php echo _tab('fatture')?'active':'';?>" aria-current="page" target="<?php echo "page_component.php?&tab=fatture&id_terapista={$_REQUEST['id_terapista']}&data={$_REQUEST['data']}"; ?>" onclick="_tab(this);">Fatture</div>
                            </div>
                        </ul>
                        <div class="p-1 page_component">
                            <?php $tab=request('tab','anagrafica'); require "{$tab}/{$tab}.php";?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-lg btn-primary disabled" id="btnSaveCliente" onclick="btnSalva()">Salva Anagrafica Cliente</a>
            </div>
        </div>
    </div>
</div>
<?php script("page_components/{$component}/view.js"); ?>