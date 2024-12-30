
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('elenco')?'active':'';?>" aria-current="page" href="corsi.php?tab=elenco&pagination=0">Elenco</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('attivi')?'active':'';?>" aria-current="page" href="corsi.php?tab=attivi&pagination=0">Corsi Attivi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('da_rinovare')?'active':'';?>" aria-current="page" href="corsi.php?tab=da_rinovare&pagination=0">Da rinovare</a>
            </li>
        </ul>
        <div class="p-1">
            <?php $tab=cookie('tab','elenco'); require "{$tab}/{$tab}.php";?>
        </div>
    </div>
</div>