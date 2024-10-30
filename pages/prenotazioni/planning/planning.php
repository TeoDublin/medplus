<?php component('calendar','css'); ?>
<?php component('hour-picker','css'); ?>
<style>
    .resizable-table th, .resizable-table td {
        position: relative;
        width: auto;
        min-width: 50px;
        white-space: nowrap;
    }
    .resizable-table th .resizer {
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        width: 2px;
        cursor: col-resize;
        background-color: rgba(var(--base-bg-primary-rgb),0.01);
    }
    .resizable-table td .resizer {
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        width: 6px;
        cursor: col-resize;
        background-color: rgba(var(--base-bg-primary-rgb),0.05);
    }
    .resizing {
        cursor: col-resize;
    }
</style>
<div class="no-scroll">
    <div class="p-3 border my-1 d-flex flex-row" style="border-bottom: 0px!important; border-radius: 10px 10px 0 0; height: 100%;">
        <div style="overflow: auto; max-height: 100%;">
            <div class="d-flex" >
                <input onclick="openCalendar(event,this)" class="hover mx-auto card-title text-center py-2 border-0 date-target" value="<?php echo cookie('date',date('d/m/Y'));?>" readonly/>
            </div>
            <table class="table table-striped border-0 resizable-table">
                <thead>
                    <?php 
                        $rows=14;
                        $terapisti=Terapisti()->select([]);                        
                    ?>
                    <tr class="align-middle"><?php
                        foreach($terapisti as $terapista){?>
                            <th scope="col" class="text-center" rowspan="2">Ora</th>
                            <th scope="col" class="text-center" rowspan="2"><?php echo $terapista['terapista'];?></th>
                            <th scope="col" class="text-center" rowspan="2">Obs</th><?php
                        }?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $planning=Select('p.*,c.nominativo,t.trattamento')
                            ->from('planning','p')
                            ->left_join('clienti c on p.id_cliente=c.id')
                            ->left_join('trattamenti t on p.id_trattamento=t.id')
                            ->where('p.data = "'.format_date(cookie('date',date('d/m/Y'))).'"')
                            ->get();
                        for($i=1;$i<=$rows;$i++){?>
                            <tr row="<?php echo $i;?>"><?php
                                foreach($terapisti as $col=>$terapista){
                                    $ora=$info=$note='';
                                    foreach ($planning as $plan) {
                                        if($plan['row']==$i&&$plan['id_terapista']==$terapista['id']){
                                            $ora=$plan['ora'];
                                            $info=$plan['nominativo'];
                                            if(!empty($info)&&!empty($plan['trattamento']))$info.=" > {$plan['trattamento']}";
                                            $note=$plan['note'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <td scope="col" class="text-center border-0" id_terapista="<?php echo $terapista['id'];?>" onclick="openHourPicker(event,this);" id="<?php echo "hourTargetr{$i}c{$col}";?>">
                                        <input class="w-100 p-0 m-0 text-center border-0 bg-transparent hour-target hover" type="text" value="<?php echo $ora ?? '';?>"  readonly />
                                    </td>
                                    <td scope="col" class="text-center border-0" id_terapista="<?php echo $terapista['id'];?>" onclick="openCustomerPicker(this);">
                                        <input class="w-100 p-0 m-0 text-center border-0 bg-transparent hover" type="text" value="<?php echo $info ?? '';?>" readonly />
                                    </td>
                                    <td scope="col" class="text-center border-0">
                                        <input class="w-100 p-0 m-0 text-center border-0 bg-transparent hover" type="text" value="<?php echo $note ?? '';?>" />
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
                _data['data']=document.querySelector('.date-target').value;
                _data['ora']=hourPicker.value.value;
                _data['id_terapista']=element.getAttribute('id_terapista');
                $.post('post/planning.php',_data).done(response=>{success();}).fail(error=>{fail(error);});
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
                    let nominativo = modalElement.querySelector('#nominativo').value;
                    let trattamento = modalElement.querySelector('#id_trattamento');
                    let options = trattamento.querySelectorAll('option');
                    let optionText = Array.from(trattamento.options).find(opt => opt.value == trattamento.value)?.textContent;
                    input.value = nominativo + ' > '+optionText;
                    const _data = {};
                    _data['operation']='all';
                    _data['row']=element.closest('tr').getAttribute('row');
                    _data['data']=document.querySelector('.date-target').value;
                    _data['ora']=element.closest('tr').querySelector('.hour-target').value;
                    _data['id_terapista']=element.getAttribute('id_terapista');
                    modalElement.querySelectorAll('[name]').forEach((modalInput)=>{ _data[modalInput.name] = modalInput.value; });
                    modal.hide();
                    $.post('post/planning.php',_data).done(response=>{success();}).fail(error=>{fail();});
                });
                modal.show();
            })
            .catch(error => {
                console.error('Error fetching customer picker:', error);
            });
    }
    
    document.addEventListener("DOMContentLoaded", () => {
        const dateTarget = document.querySelector('.date-target');
        var first = dateTarget.value;
        const observer = new MutationObserver(mutations => {
            mutations.forEach(mutation => {
                if (mutation.type === 'attributes' && mutation.attributeName === 'value') {
                    let current = dateTarget.value;
                    if(current!=first){
                        const [day, month, year] = current.split('/');
                        setCookie('currentMonth',month - 1,1);
                        setCookie('currentYear',year,1);
                        setCookie('currentDay',day,1);
                        window.location = "<?php echo url('prenotazioni.php?date=');?>"+current;
                    }
                }
            });
        });
        observer.observe(dateTarget, { attributes: true });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const table = document.querySelector('.resizable-table');
        let isResizing = false;
        let startX, startWidth, targetCell;
        table.querySelectorAll('th, td').forEach(cell => {
            const resizer = document.createElement('div');
            resizer.classList.add('resizer');
            cell.appendChild(resizer);
            resizer.addEventListener('mousedown', (e) => {
                isResizing = true;
                startX = e.pageX;
                targetCell = cell;
                startWidth = cell.offsetWidth;
                document.body.classList.add('resizing');
                e.preventDefault();
            });
        });
        document.addEventListener('mousemove', (e) => {
            if (!isResizing) return;
            const delta = e.pageX - startX;
            targetCell.style.width = `${startWidth + delta}px`;
        });
        document.addEventListener('mouseup', () => {
            if (isResizing) {
            isResizing = false;
            document.body.classList.remove('resizing');
            }
        });
    });



</script>
