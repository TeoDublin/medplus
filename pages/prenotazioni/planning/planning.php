<?php component('calendar','css'); ?>
<?php component('hour-picker','css'); ?>
<div class="no-scroll">
    <div class="p-3 border my-1 d-flex flex-row" style="border-bottom: 0px!important; border-radius: 10px 10px 0 0; height: 100%;">
        <div style="overflow: auto; max-height: 100%;">
            <div class="d-flex" >
                <input onclick="openCalendar(event,this)" class="hover mx-auto card-title text-center py-2 border-0 date-target" value="<?php echo date('d/m/Y');?>" date="<?php echo date('Y-m-d');?>" readonly/>
            </div>
            <table class="table table-striped border-0 w-100">
                <thead>
                    <?php 
                        $rows=14;
                        $terapisti=Terapisti()->select([]);                        
                    ?>
                    <tr class="align-middle"><?php
                        foreach($terapisti as $terapista){?>
                            <th scope="col" class="text-center" rowspan="2">Ora</th>
                            <th scope="col" class="text-center" rowspan="2"><?php echo $terapista['terapista'];?></th><?php
                        }?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        for($i=1;$i<=$rows;$i++){?>
                            <tr><?php
                                foreach($terapisti as $col=>$terapista){?>
                                    <td scope="col" class="text-center border w-5 hover" onclick="openHourPicker(event,this);" id="<?php echo "hourTargetr{$i}c{$col}";?>"><input class="  w-100 p-0 m-0 text-center border-0 bg-transparent" type="text" value=""  style="min-width:40px;"readonly /></td>
                                    <td scope="col" class="text-center border hover" onclick="openCustomerPicker(this);"><input class="w-100 p-0 m-0 text-center border-0 bg-transparent" type="text" value="" readonly /></td><?php
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
<?php component('customer-picker','js'); ?>
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
        const x = rect.x + window.scrollX;
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
                hourPicker.start('#'+id+' > input');
            })
            .catch(error => {
                console.error('Error fetching hourPicker:', error);
            });
    }
    function openCustomerPicker(element) {
        fetch('component.php?name=customer-picker')
            .then(response => response.text())
            .then(data => {
                const input = element.querySelector('input');
                
                const body = document.createElement('div');
                body.classList.add('modal', 'fade', 'show');
                body.setAttribute('tabindex', '-1');
                body.setAttribute('aria-modal', 'true');
                body.setAttribute('role', 'dialog');
                body.setAttribute('style', 'display: block');
                body.id = 'customerPicker';

                const container = document.createElement('div');
                container.id = body.id+"_container";
                container.classList.add('modal-dialog', 'modal-xl');

                const content = document.createElement('div');
                content.classList.add('modal-content');

                const div = document.createElement('div');
                div.classList.add('modal-body');
                div.innerHTML = data;

                content.appendChild(div);
                container.appendChild(content);
                body.appendChild(container);
                document.querySelector('.page-content').appendChild(body);
                document.querySelector('.btn-cancel').addEventListener('click', () => {
                    document.querySelector('#customerPicker').remove();
                    document.querySelector('.modal-backdrop').remove();
                });
                document.querySelector('.btn-add').addEventListener('click', () => {
                    input.value = document.querySelector('#nominativo').value;
                    document.querySelector('#customerPicker').remove();
                    document.querySelector('.modal-backdrop').remove();
                });
                const myModal = new bootstrap.Modal('#customerPicker', {
                    keyboard: false
                });
                myModal.show();
            })
            .catch(error => {
                console.error('Error fetching customer picker:', error);
            });
    }


</script>

