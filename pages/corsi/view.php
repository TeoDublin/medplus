
<?php 
$to_do=Select('
    SUM(IF(`1`=4,1,0)) +
    SUM(IF(`2`=4,1,0)) +
    SUM(IF(`3`=4,1,0)) +
    SUM(IF(`4`=4,1,0)) +
    SUM(IF(`5`=4,1,0)) +
    SUM(IF(`7`=4,1,0)) +
    SUM(IF(`8`=4,1,0)) +
    SUM(IF(`9`=4,1,0)) +
    SUM(IF(`10`=4,1,0)) +
    SUM(IF(`11`=4,1,0)
    ) AS to_do')
    ->from('view_corsi_pagamenti')
    ->col('to_do');
?>
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('elenco')?'active':'';?>" aria-current="page" href="corsi.php?tab=elenco&<?php echo unset_default();?>">Corsi</a>
            </li>
            <li class="nav-item position-relative">
                <?php 
                    if($to_do){
                        echo "<span class=\"position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger\">".
                            "{$to_do}".
                            "<span class=\"visually-hidden\">Pendenti di Conferma</span>".
                        "</span>";
                    }
                ?>
                <a class="nav-link <?php echo _tab('classi')?'active':'';?>" aria-current="page" href="corsi.php?tab=classi&<?php echo unset_default();?>">Classi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('corsi_categorie')?'active':'';?>" aria-current="page" href="corsi.php?tab=corsi_categorie&<?php echo unset_default(['unset'=>'tab']);?>">Categorie</a>
            </li>
        </ul>
        <div class="p-1">
            <?php $tab=cookie('tab','elenco'); require_once "{$tab}/{$tab}.php";?>
        </div>
    </div>
</div>