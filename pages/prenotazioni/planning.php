<link rel="stylesheet" href="<?php echo 'pages/prenotazioni/planning.css?v='.filemtime('pages/prenotazioni/planning.css');?>">
<div class="" style="overflow-x: auto; overflow-y: auto; height: 100%;">
    <div class="p-3 border my-1 d-flex flex-row" style="border-bottom: 0px!important; border-radius: 10px 10px 0 0; height: 100%;">
        <div style="overflow: auto; max-height: 100%;">
            <?php component('calendar',['id'=>'test2','toggleElement'=>'.planning-date','destination'=>'.datepicker']);?>
            <div class="planning-date d-flex">
                <input class="mx-auto card-title text-center py-2 border-0 datepicker" value="<?php echo date('d/m/Y');?>" date="<?php echo date('Y-m-d');?>"/>
            </div>
            <table class="table table-striped border-0 w-100">
                <thead>
                    <?php 
                        $rows=14;
                        $terapisti=Terapisti()->select([]);                        
                    ?>
                    <tr class="align-middle">
                        <th class="text-center" rowspan="2">Terapista/Ora</th><?php
                        foreach($terapisti as $terapista){?>
                            <th scope="col" class="text-center" rowspan="2"><?php echo $terapista['terapista'];?></th>
                            <th scope="col" class="text-center" rowspan="2">Ora</th><?php
                        }?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        for($i=1;$i<=$rows;$i++){?>
                            <tr>
                                <td scope="col" class="text-center border w-5"><input class="w-100 p-0 m-0 text-center border-0 bg-transparent" type="text" value=""/></td><?php
                                foreach($terapisti as $terapista){?>
                                    <td scope="col" class="text-center border"><input class="w-100 p-0 m-0 text-center border-0 bg-transparent" type="text" value=""/></td>
                                    <td scope="col" class="text-center border"><input class="w-100 p-0 m-0 text-center border-0 bg-transparent" type="text" value=""/></td><?php
                                }?>
                            </tr><?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="pages/prenotazioni/planning.js"></script>