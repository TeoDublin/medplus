
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('planning')?'active':'';?>" aria-current="page" href="prenotazioni.php?tab=planning">Planning</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('cartaceo')?'active':'';?>" aria-current="page" href="prenotazioni.php?tab=cartaceo">Cartaceo</a>
            </li><?php 
            if(in_array('tab_prenotazioni_motivi',$elementi)){?>
                <li class="nav-item">
                    <a class="nav-link <?php echo _tab('motivi')?'active':'';?>" aria-current="page" href="prenotazioni.php?tab=motivi&pagination=0">Motivi</a>
                </li><?php
            }?>
        </ul>
        <div class="p-1">
            <?php 
                $tab=cookie('tab','planning'); 
                require_once "{$tab}/{$tab}.php";?>
        </div>
    </div>
</div>