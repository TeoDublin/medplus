
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('planning')?'active':'';?>" aria-current="page" href="prenotazioni.php?tab=planning&pagination=0&rowId=unset&openModal=unset">Planning</a>
            </li>
        </ul>
        <div class="p-1">
            <?php 
                $tab=cookie('tab','planning'); 
                require "{$tab}/{$tab}.php";?>
        </div>
    </div>
</div>