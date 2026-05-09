
<?php 
    $corsi=Select('*')->from('view_corsi')->get();
    $tab_year=cookie('tab_year',date('Y'));

    $_has_corsi_to_confirm = function($id_corso) use(&$tab_year){
        return Select('
            SUM(IF(`1`=4,1,0)) +
            SUM(IF(`2`=4,1,0)) +
            SUM(IF(`3`=4,1,0)) +
            SUM(IF(`4`=4,1,0)) +
            SUM(IF(`5`=4,1,0)) +
            SUM(IF(`7`=4,1,0)) +
            SUM(IF(`8`=4,1,0)) +
            SUM(IF(`9`=4,1,0)) +
            SUM(IF(`10`=4,1,0)) +
            SUM(IF(`11`=4,1,0))
        AS to_do')
        ->from('view_corsi_pagamenti')
        ->where("id_corso={$id_corso}")
        ->and("anno={$tab_year}")
        ->groupby('id_corso')
        ->col('to_do');
    };

    function _has_corsi_to_confirm_by_year($year){
        return Select('
            SUM(IF(`1`=4,1,0)) +
            SUM(IF(`2`=4,1,0)) +
            SUM(IF(`3`=4,1,0)) +
            SUM(IF(`4`=4,1,0)) +
            SUM(IF(`5`=4,1,0)) +
            SUM(IF(`7`=4,1,0)) +
            SUM(IF(`8`=4,1,0)) +
            SUM(IF(`9`=4,1,0)) +
            SUM(IF(`10`=4,1,0)) +
            SUM(IF(`11`=4,1,0))
        AS to_do')
        ->from('view_corsi_pagamenti')
        ->where("anno={$year}")
        ->groupby('anno')
        ->col('to_do');
    }
?>

<div class="d-flex w-100 py-3" id="tab-year">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <?php 
                $start_year = $year = 2025;

                while ($year >= $start_year && $year <= date('Y')) {
                    $is_active=($tab_year==$year);
                    
                    echo "<li class=\"nav-item nav-classi-item position-relative\">";
                    if(($n=_has_corsi_to_confirm_by_year($year))){
                        echo "<span class=\"position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger\">".
                                "{$n}".
                                "<span class=\"visually-hidden\">Pendenti di Conferma</span>".
                            "</span>";
                    }
                    echo "<a class=\"nav-link ".($is_active?'active':'')."\" aria-current=\"page\" href=\"corsi.php?".unset_default(['tab'=>'classi','tab_year'=>$year])."\">{$year}</a>".
                    "</li>";
                    $is_first=false;
                    $year++;
                }
            ?>
        </ul>
    </div>
</div>

<div class="d-flex w-100 py-3" id="tab-classi">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <?php 
                $is_first=true;
                $tab_classi=cookie('tab_classi',false);
                foreach ($corsi as $corso) {
                    if((!$tab_classi&&$is_first)||($tab_classi==$corso['id'])){
                        $is_active=true;
                        $tab_classi=$corso['id'];
                        $corso_current=$corso;
                    }
                    else $is_active=false;
                    echo "<li class=\"nav-item nav-classi-item position-relative\">";
                    if(($n=$_has_corsi_to_confirm($corso['id']))){
                        echo "<span class=\"position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger\">".
                                "{$n}".
                                "<span class=\"visually-hidden\">Pendenti di Conferma</span>".
                            "</span>";
                    }
                    echo "<a class=\"nav-link ".($is_active?'active':'')."\" aria-current=\"page\" href=\"corsi.php?".unset_default(['tab'=>'classi','tab_classi'=>$corso['id']])."\">{$corso['corso']}</a>".
                    "</li>";
                    $is_first=false;
                }
            ?>
        </ul>
    </div>
</div>