
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('planning')?'active':'';?>" aria-current="page" href="prenotazioni.php?tab=planning">Planning</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('motivi')?'active':'';?>" aria-current="page" href="prenotazioni.php?tab=motivi&pagination=0">Motivi</a>
            </li>
        </ul>
        <div class="p-1">
            <?php 
                $tab=cookie('tab','planning'); 
                require "{$tab}/{$tab}.php";?>
        </div>
    </div>
</div>