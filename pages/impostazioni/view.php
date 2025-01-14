
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('terapisti')?'active':'';?>" href="impostazioni.php?tab=terapisti&pagination=0" aria-current="page">Terapisti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('motivi')?'active':'';?>" href="impostazioni.php?tab=motivi&pagination=0" aria-current="page">Motivi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('corsi_categorie')?'active':'';?>" href="impostazioni.php?tab=corsi_categorie&pagination=0" aria-current="page">Categorie Corsi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('trattamenti_categorie')?'active':'';?>" href="impostazioni.php?tab=trattamenti_categorie&pagination=0" aria-current="page">Categorie Trattamenti</a>
            </li>
        </ul>
        <div class="p-1">
            <?php $tab=cookie('tab','terapisti'); require "{$tab}/{$tab}.php";?>
        </div>
    </div>
</div>