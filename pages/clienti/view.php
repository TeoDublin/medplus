
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('anagrafica')?'active':'';?>" aria-current="page" href="clienti.php?tab=anagrafica&pagination=0&rowId=unset&openModal=unset">Anagrafica</a>
            </li>
        </ul>
        <div class="p-1">
            <?php  require cookie('tab','anagrafica').'.php';?>
        </div>
    </div>
</div>