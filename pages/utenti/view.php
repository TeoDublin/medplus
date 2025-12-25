
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('elenco')?'active':'';?>" aria-current="page" href="utenti.php?<?php echo unset_default(['tab'=>'elenco']);?>">Utenti</a>
            </li>
            <?php 
                if(in_array('tab_utenti_presenze',$elementi)){?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo _tab('presenze_log')?'active':'';?>" aria-current="page" href="utenti.php?<?php echo unset_default(['tab'=>'presenze_log']);?>">Presenze Log</a>
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