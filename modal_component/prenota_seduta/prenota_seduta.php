<?php style('modal_component/prenota_seduta/prenota_seduta.css');
    $date=$_REQUEST['date']??now('Y-m-d');
    $month=$_REQUEST['month']??substr($date,5,2);
    $year=substr($date,0,4);
?>
<div class="modal bg-dark bg-opacity-50" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content px-3 text-center">
            <div class="modal-header">
                <div class="w-30 me-1">
                    <select class="form-select" id="prenota_terapista"  value=""><?php
                        foreach(Select('*')->from('terapisti')->get() as $terapista){
                            echo "<option value=\"{$terapista['id']}\" class=\"ps-4  bg-white\">{$terapista['terapista']}</option>";
                        }?>
                    </select>
                </div>
                <div class="w-30 me-1">
                    <select class="form-select" id="prenota_month"  value="" onchange="monthChange(this)"><?php
                        for($i=1;$i<=12;$i++){
                            echo "<option value=\"{$i}\" class=\"ps-4  bg-white\"".($i==$month?'selected':'').">".italian_month($i)."</option>";
                        }?>
                    </select>
                </div>
                <div class="w-30">
                    <select class="form-select" id="prenota_year"  value=""><?php
                        for($i=1;$i<=5;$i++){
                            $add_year=(int)$year-3+$i;
                            echo "<option value=\"{$add_year}\" class=\"ps-4  bg-white\"".($add_year==$year?'selected':'').">".$add_year."</option>";
                        }
                    ?>
                    </select>
                </div>
                <button type="button" class="btn-resize" aria-hidden="true" onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <input name="date" value="<?php echo $date;?>" hidden/>
                <div class="p-2 border rounded">
                    <div class="d-flex flex-row">
                        <div class="c1 day-name" data-full="lunedi" data-short="Lu"></div>
                        <div class="c1 day-name" data-full="martedi" data-short="Ma"></div>
                        <div class="c1 day-name" data-full="mercoledi" data-short="Me"></div>
                        <div class="c1 day-name" data-full="giovedi" data-short="Gi"></div>
                        <div class="c1 day-name" data-full="venerdi" data-short="Ve"></div>
                        <div class="c1 day-name" data-full="sabato" data-short="Sa"></div>
                        <div class="c1 day-name flex-fill" data-full="domenica" data-short="Do"></div>
                    </div>
                    <?php 
                        $current_day = 1;
                        $daysInMonth = (int)date('t', strtotime("$year-$month-01"));
                        for($i=0;$i<6;$i++){?>
                            <div class="d-flex flex-row"><?php
                                for($j=1;$j<=7;$j++){
                                    $day=(int)date('N', strtotime("$year-$month-$current_day"));
                                    $last=$j==7?'flex-fill':'';
                                    if($current_day>$daysInMonth)echo "<div class=\"c1 calendar-out $last\" onclick=\"dayClick(this);\"></div>";
                                    else{
                                        echo "<div class=\"c1 calendar-out $last\" onclick=\"dayClick(this);\">";
                                        if($day==$j){
                                            echo str_pad($current_day,2,'0',STR_PAD_LEFT);
                                            $current_day++;
                                        }
                                        echo "</div>";
                                        
                                    }
                                }?>
                            </div><?php
                            }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" data-bs-dismiss="modal" class="btn btn-secondary">Anulla</a>
                <a href="#" class="btn btn-primary" onclick="btnSalva('<?php echo $_REQUEST['id_modal'];?>')">Salva</a>
            </div>
        </div>
    </div>
</div>
<div class="p-2" id="prenota-prenota_seduta_planning"></div>
<?php script('modal_component/prenota_seduta/prenota_seduta.js'); ?>
