
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('elenco')?'active':'';?>" aria-current="page" href="utenti.php?tab=elenco&pagination=0">Utenti</a>
            </li>
            <?php 
                if(in_array('tab_utenti_presenze',$elementi)){?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo _tab('presenze')?'active':'';?>" aria-current="page" href="utenti.php?tab=presenze&pagination=0">Presenze</a>
                    </li>
                    <?php
                }
            ?>

        </ul>
        <div class="p-1">
            <?php 
                $tab=cookie('tab','elenco'); 
                require_once "{$tab}/{$tab}.php";?>
        </div>
    </div>
</div>