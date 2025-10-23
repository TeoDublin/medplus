<?php
    style('pdf_component/sedute/sedute.css');
    $query = Session()->get('last_query');
    $total_prezzo = $total_saldo = $count = 0;
    $select=Sql()->select($query);
?>

<div class="container-fluid text-center">
    <h2>Report <?php echo $select[0]['terapista']; ?></h2>
    <div class="table-responsive my-2">
        <div class="d-flex flex-row font-bold w-100 py-2 bg-dark fs-5 color-white">
            <div class="w-15">Data Seduta</div>
            <div class="w-20">Acron.</div>
            <div class="flex-fill">Cliente</div>
            <div class="w-15">Saldo</div>
            <div class="w-15">Prezzo</div>
            <div class="w-15">Voucher</div>
        </div>
    </div>
    <?php 
        foreach ($select as $result) {
            $saldo = floatval($result['saldo_terapista']);
            $prezzo = floatval($result['prezzo']);
            echo '<div class="d-flex flex-row w-100">';
                echo '<div class="w-15 border">' . unformat_date($result['data_seduta']) . '</div>';
                echo '<div class="w-20 border">' . _txt($result['acronimo']) . '</div>';
                echo '<div class="flex-fill border">' . _txt($result['nominativo']) . '</div>';
                echo '<div class="w-15 border">' . number_format($saldo, 2, '.', '') . '</div>';
                echo '<div class="w-15 border">' . number_format($prezzo, 2, '.', '') . '</div>';
                echo '<div class="w-15 border">' ._txt($result['bnw']) . '</div>';
            echo '</div>';
            $total_saldo += $saldo;
            $count++;
        }
    ?>
    <div class="d-flex flex-row mt-10 font-bold fs-5 mt-3">
        <div class="flex-fill"></div>
        <div class="w-15">Quantità</div>
        <div class="w-15">Saldo</div>
    </div>
    <div class="d-flex flex-row mt-10 font-bold fs-5 mt-1">
        <div class="flex-fill border">TOTALE</div>
        <div class="w-15 border"><?php echo $count; ?></div>
        <div class="w-15 border"><?php echo number_format($total_saldo, 2, '.', ''); ?></div>
    </div>
</div>
