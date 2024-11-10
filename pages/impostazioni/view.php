
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('trattamenti')?'active':'';?>" aria-current="page" href="impostazioni.php?tab=trattamenti&pagination=0&rowId=unset">Trattamenti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('terapisti')?'active':'';?>" href="impostazioni.php?tab=terapisti&pagination=0&rowId=unset" aria-current="page">Terapisti</a>
            </li>
        </ul>
        <div class="p-1">
            <?php $tab=cookie('tab','trattamenti'); require "{$tab}/{$tab}.php";?>
        </div>
    </div>
</div>