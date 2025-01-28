
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('elenco')?'active':'';?>" aria-current="page" href="trattamenti.php?tab=elenco&pagination=0">Trattamenti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('trattamenti_categorie')?'active':'';?>" aria-current="page" href="trattamenti.php?tab=trattamenti_categorie&pagination=0">Categorie</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('da_prenotare')?'active':'';?>" aria-current="page" href="trattamenti.php?tab=da_prenotare&pagination=0">Da Prenotare</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('da_rinovare')?'active':'';?>" aria-current="page" href="trattamenti.php?tab=da_rinovare&pagination=0">Da Rinovare</a>
            </li>
        </ul>
        <div class="p-1">
            <?php $tab=cookie('tab','elenco'); require "{$tab}/{$tab}.php";?>
        </div>
    </div>
</div>