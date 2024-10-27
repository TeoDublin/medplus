<link rel="stylesheet" href="<?php echo 'pages/prenotazioni/planning.css?v='.filemtime('pages/prenotazioni/planning.css');?>">
<?php component('calendar','css'); ?>
<?php component('hour-picker','css'); ?>
<div class="" style="overflow-x: auto; overflow-y: auto; height: 100%;">
    <div class="p-3 border my-1 d-flex flex-row" style="border-bottom: 0px!important; border-radius: 10px 10px 0 0; height: 100%;">
        <div style="overflow: auto; max-height: 100%;">
            <div class="datepicker d-flex" onclick="openCalendar(event,this)">
                <input class="mx-auto card-title text-center py-2 border-0 date-target" value="<?php echo date('d/m/Y');?>" date="<?php echo date('Y-m-d');?>"/>
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
                                <td scope="col" class="text-center border w-5" onclick="openHourPicker(event,this);" id="hourTarget_<?php echo $i;?>"><input id="hourTarget_<?php echo $i;?>" class="  w-100 p-0 m-0 text-center border-0 bg-transparent" type="text" value=""/></td><?php
                                foreach($terapisti as $terapista){?>
                                    <td scope="col" class="text-center border" ><input class="w-100 p-0 m-0 text-center border-0 bg-transparent" type="text" value=""/></td>
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
<?php component('calendar','js'); ?>
<?php component('hour-picker','js'); ?>
<script>
    function openCalendar(event, element) {
        const rect = event.target.getBoundingClientRect();
        fetch('component.php?name=calendar')
            .then(response => response.text())
            .then(data => {
                const content = document.createElement('div');
                content.innerHTML = data;
                document.querySelector('.page-content').appendChild(content);
            })
            .then(() => {
                calendar.start('.date-target',rect.x,rect.y);
            })
            .catch(error => {
                console.error('Error fetching calendar:', error);
            });
    }
    function openHourPicker(event, element) {
        document.querySelectorAll('#hourPicker').forEach((element)=>{element.remove();});
        const id = element.id;
        const rect = event.target.getBoundingClientRect();
        const x = rect.x;
        const y = rect.y + window.scrollY;
        fetch('component.php?name=hour-picker')
            .then(response => response.text())
            .then(data => {
                const content = document.createElement('div');
                content.id="hourPicker";
                content.setAttribute('style', 'left:'+x+'px;top:'+y+'px;position:absolute;');
                content.innerHTML = data;
                document.querySelector('.page-content').appendChild(content);
            })
            .then(() => {
                hourPicker.start('input#'+id);
            })
            .catch(error => {
                console.error('Error fetching hourPicker:', error);
            });
    }
</script>

