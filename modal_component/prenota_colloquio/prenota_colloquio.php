<?php component('planning','css');?>
<div class="modal bg-dark bg-opacity-50 vh-100" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" >
    <div class="modal-dialog modal-fullscreen modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Planning</h4>
                <button type="button" class="btn-resize"  onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-span="Close"></button>
            </div>
            <div class="modal-body"><?php
                echo "<input id=\"id_cliente\" value=\"{$_REQUEST['id_cliente']}\" hidden/>";
                component('planning','php');?>
            </div>
        </div>
    </div>
</div>
<?php script('modal_component/prenota_colloquio/prenota_colloquio.js');?>