
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('elenco')?'active':'';?>" aria-current="page" href="terapisti.php?tab=elenco&pagination=0">Terapisti</a>
            </li>
        </ul>
        <div class="p-1">
            <?php 
                $tab=cookie('tab','elenco'); 
                require "{$tab}/{$tab}.php";?>
        </div>
    </div>
</div>