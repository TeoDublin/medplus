<?php component('calendar','css'); ?>
<?php component('hour-picker','css'); ?>
<?php style('pages/prenotazioni/planning/planning.css'); ?>
<div class="no-scroll">
    <div class="p-3 border my-1 d-flex flex-row" style="border-bottom: 0px!important; border-radius: 10px 10px 0 0; height: 100%;">
        <div style="overflow: auto; max-height: 100%;">
            <div class="d-flex" >
                <input onclick="openCalendar(event,this)" class="hover mx-auto card-title text-center py-2 border-0 date-target" value="<?php echo cookie('date',date('d/m/Y'));?>" readonly/>
            </div>
            <table class="table table-striped border-0 resizable-table">
                <thead>
                    <?php 
                        $rows=15;
                        $terapisti=Select('*')->from('terapisti')->get();                        
                    ?>
                    <tr class="align-middle"><?php
                        foreach($terapisti as $terapista){?>
                            <th scope="col" class="text-center" rowspan="2">Ora</th>
                            <th scope="col" class="text-center" rowspan="2"><?php echo $terapista['terapista'];?></th>
                            <th scope="col" class="text-center" rowspan="2">TR</th><?php
                        }?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $planning=Select('p.*,c.nominativo,t.trattamento')
                            ->from('planning','p')
                            ->left_join('clienti c on p.tabella_riferimento = "clienti" and p.id_riferimento = c.id')
                            ->left_join('trattamenti t on p.id_trattamento=t.id')
                            ->where('p.data = "'.format_date(cookie('date',date('d/m/Y'))).'"')
                            ->get();
                        for($i=1;$i<=$rows;$i++){?>
                            <tr row="<?php echo $i;?>" row="<?php echo $i;?>"><?php
                                foreach($terapisti as $col=>$terapista){
                                    $ora=$info=$note=$id_planning='';
                                    foreach ($planning as $plan) {
                                        if($plan['row']==$i&&$plan['id_terapista']==$terapista['id']){
                                            $ora=$plan['ora'];
                                            $info=$plan['nominativo'];
                                            if(!empty($info)&&!empty($plan['trattamento']))$info.=" > {$plan['trattamento']}";
                                            $note=$plan['note'];
                                            $id_planning=$plan['id'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <td scope="col" class="text-center border-0" id_planning="<?php echo $id_planning;?>" hidden></td>
                                    <td scope="col" class="text-center border-0" id_terapista="<?php echo $terapista['id'];?>" id="<?php echo "hourTargetr{$i}c{$col}";?>" onclick="hourClick(this);">
                                        <input class="w-100 p-0 m-0 text-center border-0 bg-transparent hour-target hover" type="text" value="<?php echo $ora ?? '';?>"  readonly />
                                    </td>
                                    <td scope="col" class="text-center border-0" id_terapista="<?php echo $terapista['id'];?>" onclick="openCustomerPicker(this);">
                                        <input class="w-100 p-0 m-0 text-center border-0 bg-transparent hover" type="text" value="<?php echo $info ?? '';?>" readonly />
                                    </td>
                                    <td scope="col" class="text-center border-0" >
                                        <input class="w-100 p-0 m-0 text-center border-0 bg-transparent hover note" id_terapista="<?php echo $terapista['id'];?>" type="text" value="<?php echo $note ?? '';?>" onclick="noteClick(this);" />
                                    </td><?php
                                }?>
                            </tr><?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php component('calendar','js'); ?>
<?php component('hour-picker','js'); ?>
<?php component_page('customer-picker','anagrafica','js'); ?>
<?php script('pages/prenotazioni/planning/planning.js'); ?>
<script>
    sessionStorage.setItem('prenotazioni_url',"<?php echo url('prenotazioni.php?date=');?>");
</script>