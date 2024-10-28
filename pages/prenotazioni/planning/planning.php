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
                            <tr row="<?php echo $i;?>"><?php
                                foreach($terapisti as $col=>$terapista){?>
                                    <td scope="col" class="text-center border w-5 hover" id_terapista="<?php echo $terapista['id'];?>" onclick="openHourPicker(event,this);" id="<?php echo "hourTargetr{$i}c{$col}";?>"><input class="  w-100 p-0 m-0 text-center border-0 bg-transparent hour-target" type="text" value=""  style="min-width:40px;"readonly /></td>
                                    <td scope="col" class="text-center border hover" id_terapista="<?php echo $terapista['id'];?>" onclick="openCustomerPicker(this);"><input class="w-100 p-0 m-0 text-center border-0 bg-transparent" type="text" value="" readonly /></td><?php
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
                hourPicker.closeBtn.addEventListener('click',()=>{
                const _data = {};
                _data['operation']='hour';
                _data['row']=element.closest('tr').getAttribute('row');
                _data['data']=document.querySelector('.date-target').getAttribute('date');
                _data['ora']=hourPicker.value.value;
                _data['id_terapista']=element.getAttribute('id_terapista');
                $.post('post/planning.php',_data).done(response=>{alert('insert ok')}).fail(error=>{alert(error);});
            });                
            })
            .catch(error => {
                console.error('Error fetching hourPicker:', error);
            });
    }
    function openCustomerPicker(element) {
        fetch('component.php?name=customer-picker')
            .then(response => response.text())
            .then(data => {
                document.querySelector('#modal-body').innerHTML = data;
                const modalElement = document.getElementById('modal');
                const modal = new bootstrap.Modal(modalElement);
                modalElement.querySelector('.modal-title').textContent = 'Seleziona cliente';
                modalElement.querySelector('.modal-dialog').classList.add('modal-xl');
                const addButton = modalElement.querySelector('.btn-add');
                addButton.replaceWith(addButton.cloneNode(true));
                const newAddButton = modalElement.querySelector('.btn-add');                
                modalElement.querySelector('.btn-add').addEventListener('click', () => {
                    const input = element.querySelector('input');
                    input.value = modalElement.querySelector('#nominativo').value;
                    const _data = {};
                    _data['operation']='all';
                    _data['row']=element.closest('tr').getAttribute('row');
                    _data['data']=document.querySelector('.date-target').getAttribute('date');
                    _data['ora']=element.closest('tr').querySelector('.hour-target').value;
                    _data['id_terapista']=element.getAttribute('id_terapista');
                    modalElement.querySelectorAll('[name]').forEach((modalInput)=>{ _data[modalInput.name] = modalInput.value; });
                    modal.hide();
                    $.post('post/planning.php',_data).done(response=>{alert('insert ok')}).fail(error=>{alert(error);});
                });
                modal.show();
            })
            .catch(error => {
                console.error('Error fetching customer picker:', error);
            });
    }
</script>
