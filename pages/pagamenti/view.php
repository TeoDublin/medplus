
<div class="py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('sedute')?'active':'';?>" aria-current="page" href="pagamenti.php?<?php echo unset_default(['tab'=>'sedute']);?>">Sedute</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('corsi')?'active':'';?>" aria-current="page" href="pagamenti.php?<?php echo unset_default(['tab'=>'corsi']);?>">Corsi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('fatture')?'active':'';?>" aria-current="page" href="pagamenti.php?<?php echo unset_default(['tab'=>'fatture']);?>">Fatture</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('incassi')?'active':'';?>" aria-current="page" href="pagamenti.php?<?php echo unset_default(['tab'=>'incassi']);?>">Incassi</a>
            </li>
        </ul>
        <div class="p-1">
            <?php 
                $tab=cookie('tab','sedute'); 
                require_once "{$tab}/{$tab}.php";
            ?>
        </div>
    </div>
</div>