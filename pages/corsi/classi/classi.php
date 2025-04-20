<?php 
    style('pages/corsi/classi/classi.css');
    require 'ctrl.php';
    $year='2025';
    $view_classi = Select('*')
        ->from('view_corsi_pagamenti','vc')
        ->where("vc.id_corso={$tab_classi} and vc.anno = '{$year}'")
        ->get_table();

    $data_inizio = new DateTime($corso_current['timestamp']);
    $data_inizio->setTime(0, 0, 0);
    $inizio = $data_inizio->format('Y-m-01');
    $current_month = new DateTime(date('Y-m-01'));
    $current_month->setTime(0, 0, 0);

    $_classe_icon = function($m,$classe) use (&$year, &$inizio, &$current_month) {
        $classe['scadenza']="{$year}-".str_pad($m,2,'0',STR_PAD_LEFT)."-".str_pad($classe['corso_scadenza'],2,'0',STR_PAD_LEFT);
        $classe['mese']=$m;
        $classe['anno']=$year;
        $data_set=data_set($classe)." onclick=\"window.modalHandlers['classi'].click(this)\"";
        switch ($classe[$m]) {
            case '1': return "<div {$data_set}>".icon('check.svg', 'green', 20, 20)."</div>";
            case '2': return "<div {$data_set}>".icon('x.svg', 'red', 20, 20)."</div>";
            case '3': return "<div {$data_set}>".icon('circle.svg', 'gray', 20, 20)."</div>";
            case '4': return "<div {$data_set}>".icon('circle.svg', 'red', 20, 20)."</div>";
        }
    };
        
?>
<div class="px-1">
    <div class="d-flex flex-column">
        <div>
            <label for="terapista">Terapista:</label>
            <span name="terapista" id="terapista"><?php echo $corso_current['terapista']; ?></span>
        </div>
    </div>
</div>
<div class="px-1">
    <table class="table table-striped table-hover text-center">
        <thead>
            <tr>
                <th class="">Nominativo</th>
                <th class="w-5">gen</th>
                <th class="w-5">feb</th>
                <th class="w-5">mar</th>
                <th class="w-5">apr</th>
                <th class="w-5">mag</th>
                <th class="w-5">giu</th>
                <th class="w-5">lug</th>
                <th class="w-5">ago</th>
                <th class="w-5">set</th>
                <th class="w-5">oto</th>
                <th class="w-5">nov</th>
                <th class="w-5">dic</th>
            </tr>
        </thead>
        <tbody><?php 
            foreach($view_classi->result as $classe){?>
                <tr data-id=<?php echo $classe['id']; ?>>
                    <td><?php echo $classe['nominativo']; ?></td>
                    <td><?php echo $_classe_icon(1,$classe); ?></td>
                    <td><?php echo $_classe_icon(2,$classe); ?></td>
                    <td><?php echo $_classe_icon(3,$classe); ?></td>
                    <td><?php echo $_classe_icon(4,$classe); ?></td>
                    <td><?php echo $_classe_icon(5,$classe); ?></td>
                    <td><?php echo $_classe_icon(6,$classe); ?></td>
                    <td><?php echo $_classe_icon(7,$classe); ?></td>
                    <td><?php echo $_classe_icon(8,$classe); ?></td>
                    <td><?php echo $_classe_icon(9,$classe); ?></td>
                    <td><?php echo $_classe_icon(10,$classe); ?></td>
                    <td><?php echo $_classe_icon(11,$classe); ?></td>
                    <td><?php echo $_classe_icon(12,$classe); ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
<?php script('pages/corsi/classi/classi.js'); ?>