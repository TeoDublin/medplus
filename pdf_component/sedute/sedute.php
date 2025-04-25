<?php
    style('pdf_component/sedute/sedute.css');
    $query = Session()->get('last_query');
    $total = 0;
?>

<div class="container-fluid text-center">
    <h2>Report Terapista</h2>
    <div class="table-responsive my-2">
        <div class="d-flex flex-row font-bold w-100 py-2 bg-dark fs-5 color-white">
            <div class="w-15">Data Seduta</div>
            <div class="w-20">Acron.</div>
            <div class="w-10">N.</div>
            <div class="flex-fill">Cliente</div>
            <div class="w-15">Saldo</div>
        </div>
    </div>
    <?php 
        foreach (Sql()->select($query) as $result) {
            $saldo = floatval($result['saldo_terapista']);
            echo '<div class="d-flex flex-row w-100">';
                echo '<div class="w-15 border">' . unformat_date($result['data_seduta']) . '</div>';
                echo '<div class="w-20 border">' . _txt($result['acronimo']) . '</div>';
                echo '<div class="w-10 border">' . $result['index'] . '</div>';
                echo '<div class="flex-fill border">' . _txt($result['nominativo']) . '</div>';
                echo '<div class="w-15 border">' . number_format($saldo, 2, '.', '') . '</div>';
            echo '</div>';
            $total += $saldo;
        }
    ?>
    <div class="d-flex flex-row mt-10 font-bold fs-5 mt-3">
        <div class="flex-fill border">TOTALE</div>
        <div class="w-15 border"><?php echo number_format($total, 2, '.', ''); ?></div>
    </div>
</div>
