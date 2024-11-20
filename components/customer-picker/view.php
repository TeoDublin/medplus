
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('anagrafica')?'active':'';?>" aria-current="page" href="component_page.php?tab=anagrafica&skip_cookie=true&name=customer-picker">Anagrafica</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('trattamenti')?'active':'';?>" aria-current="page" href="component_page.php?tab=trattamenti&skip_cookie=true&name=customer-picker">trattamenti</a>
            </li>
        </ul>
        <div class="p-1">
            <?php $tab=$_REQUEST['tab']; require "{$tab}/{$tab}.php";?>
        </div>
    </div>
</div>