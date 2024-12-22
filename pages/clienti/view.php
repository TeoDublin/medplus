
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('anagrafica')?'active':'';?>" aria-current="page" href="clienti.php?tab=anagrafica&pagination=0&rowId=unset&openModal=unset">Anagrafica</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('percorsi')?'active':'';?>" aria-current="page" href="clienti.php?tab=percorsi&pagination=0&rowId=unset&openModal=unset">Percorsi</a>
            </li>
        </ul>
        <div class="p-1">
            <?php $tab=cookie('tab','anagrafica');require "{$tab}/{$tab}.php";?>
        </div>
    </div>
</div>