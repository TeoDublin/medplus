
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('planning')?'active':'';?>" aria-current="page" href="prenotazioni.php?tab=planning&pagination=0&rowId=unset&openModal=unset">Planner</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('in_programma')?'active':'';?>" aria-current="page" href="prenotazioni.php?tab=in_programma&pagination=0&rowId=unset&openModal=unset">In programma</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('pendenti')?'active':'';?>" aria-current="page" href="prenotazioni.php?tab=pendenti&pagination=0&rowId=unset&openModal=unset">Pendenti</a>
            </li>
        </ul>
        <div class="p-1">
            <?php  require cookie('tab','planning').'.php';?>
        </div>
    </div>
</div>