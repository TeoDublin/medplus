
<div class="d-flex w-100 py-3 page_component">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <div class="nav-item tab">
                <div class="nav-link <?php echo _tab('anagrafica')?'active':'';?>" aria-current="page" target="<?php echo "page_component.php?skip_cookie=true&name=customer-picker&tab=anagrafica&row={$_REQUEST['row']}&id_terapista={$_REQUEST['id_terapista']}&data={$_REQUEST['data']}"; ?>" onclick="_tab(this);">Anagrafica</div>
            </div>
            <div class="nav-item tab">
                <div class="nav-link <?php echo _tab('trattamenti')?'active':'';?>" aria-current="page" target="<?php echo "page_component.php?skip_cookie=true&name=customer-picker&tab=trattamenti&row={$_REQUEST['row']}&id_terapista={$_REQUEST['id_terapista']}&data={$_REQUEST['data']}"; ?>" onclick="_tab(this);">Trattamenti</div>
            </div>
            <div class="nav-item tab">
                <div class="nav-link <?php echo _tab('fatture')?'active':'';?>" aria-current="page" target="<?php echo "page_component.php?skip_cookie=true&name=customer-picker&tab=fatture&row={$_REQUEST['row']}&id_terapista={$_REQUEST['id_terapista']}&data={$_REQUEST['data']}"; ?>" onclick="_tab(this);">Fatture</div>
            </div>
        </ul>
        <div class="p-1">
            <?php $tab=request('tab','anagrafica'); require "{$tab}/{$tab}.php";?>
        </div>
    </div>
</div>
<?php script("page_components/{$component}/view.js"); ?>