<?php style('modal_component/calendar/calendar.css');
    $date=$_REQUEST['date']??now('Y-m-d');
    $month=substr($date,5,2);
    $year=substr($date,0,4);
?>
<div class="modal bg-dark bg-opacity-50" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="w-30 me-1">
                    <select class="form-select" id="month"  value=""><?php
                        for($i=1;$i<=12;$i++){
                            echo "<option value=\"{$i}\" class=\"ps-4  bg-white\"".($i==$month?'selected':'').">".italian_month($i)."</option>";
                        }?>
                    </select>
                </div>
                <div class="w-30">
                    <select class="form-select" id="year"  value=""><?php
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
                <input value="<?php echo $date;?>" hidden/>
                <div class="p-2">
                    <div class="calendar">
                        <div class="d-flex flex-row row">
                            <div class="c1 day-name" data-full="lunedi" data-short="Lu"></div>
                            <div class="c1 day-name" data-full="martedi" data-short="Ma"></div>
                            <div class="c1 day-name" data-full="mercoledi" data-short="Me"></div>
                            <div class="c1 day-name" data-full="giovedi" data-short="Gi"></div>
                            <div class="c1 day-name" data-full="venerdi" data-short="Ve"></div>
                            <div class="c1 day-name" data-full="sabato" data-short="Sa"></div>
                            <div class="c1 day-name flex-fill" data-full="domenica" data-short="Do"></div>
                        </div>

                        <div id="calendar-body">
                            <div class="d-flex flex-row row">
                                <div class="c1 calendar-out"></div>
                                <div class="c1 calendar-out"></div>
                                <div class="c1 calendar-out"></div>
                                <div class="c1 calendar-out"></div>
                                <div class="c1 calendar-out"></div>
                                <div class="c1 calendar-out"></div>
                                <div class="c1 calendar-in flex-fill first">1</div>
                            </div>
                            <div class="d-flex flex-row row">
                                <div class="c1 calendar-in">2</div>
                                <div class="c1 calendar-in">3</div>
                                <div class="c1 calendar-in">4</div>
                                <div class="c1 calendar-in">5</div>
                                <div class="c1 calendar-in">6</div>
                                <div class="c1 calendar-current">7</div>
                                <div class="c1 calendar-in flex-fill">8</div>
                            </div>
                            <div class="d-flex flex-row row">
                                <div class="c1 calendar-in">9</div>
                                <div class="c1 calendar-in">10</div>
                                <div class="c1 calendar-in">11</div>
                                <div class="c1 calendar-in">12</div>
                                <div class="c1 calendar-in">13</div>
                                <div class="c1 calendar-in">14</div>
                                <div class="c1 calendar-in flex-fill">15</div>
                            </div>
                            <div class="d-flex flex-row row">
                                <div class="c1 calendar-in">16</div>
                                <div class="c1 calendar-in">17</div>
                                <div class="c1 calendar-in">18</div>
                                <div class="c1 calendar-in">19</div>
                                <div class="c1 calendar-in">20</div>
                                <div class="c1 calendar-in">21</div>
                                <div class="c1 calendar-in flex-fill">22</div>
                            </div>
                            <div class="d-flex flex-row row">
                                <div class="c1 calendar-in">23</div>
                                <div class="c1 calendar-in">24</div>
                                <div class="c1 calendar-in">25</div>
                                <div class="c1 calendar-in">26</div>
                                <div class="c1 calendar-in">27</div>
                                <div class="c1 calendar-in">28</div>
                                <div class="c1 calendar-in flex-fill">29</div>
                            </div>
                            <div class="d-flex flex-row row last">
                                <div class="c2 calendar-in">30</div>
                                <div class="c2 calendar-in">31</div>
                                <div class="c2 calendar-out"></div>
                                <div class="c2 calendar-out"></div>
                                <div class="c2 calendar-out"></div>
                                <div class="c2 calendar-out"></div>
                                <div class="c2 calendar-out flex-fill"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" data-bs-dismiss="modal" class="btn btn-secondary">Anulla</a>
                <a href="#" class="btn btn-primary" onclick="btnSalva('<?php echo $_REQUEST['id_modal'];?>')">Salva</a>
            </div>
        </div>
    </div>
</div>
<?php script('modal_component/calendar/calendar.js'); ?>
