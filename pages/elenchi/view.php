
<?php  
    function _tab_name():string{
        return $_REQUEST['tab']??'trattamenti';
    }
    function _tab($tab):bool{
        return _tab_name()==$tab;
    }

?>
<div class="d-flex w-100 py-3">
    <div class="flex-fill flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('trattamenti')?'active':'';?>" aria-current="page" href="elenchi.php?tab=trattamenti">Trattamenti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo _tab('terapisti')?'active':'';?>" href="elenchi.php?tab=terapisti" aria-current="page">Terapisti</a>
            </li>
        </ul>
        <div class="p-1">
            <?php  
                switch (_tab_name()) {
                    case 'trattamenti':
                        html()->table(['Trattamento'],Trattamenti()->select_for_table(['select'=>['t_id','t_trattamento']]),['del','edit']);
                        break;
                    case 'terapisti':
                        html()->table(['Terapista'],Terapisti()->select_for_table(['select'=>['t_id','t_terapista']]),['del','edit']);
                        break;
                }
                ?>
        </div>
    </div>
</div>
<script>
    const actions = {
        del:document.querySelectorAll('.action-del'),
        edit:document.querySelectorAll('.action-edit'),
        listen: function(){
            const delClick =(event)=>{
                const row = event.target.closest('tr');
                const rowIdCell = row.querySelector('#row_id');
                const rowIdText = rowIdCell ? rowIdCell.textContent : 'Row ID not found';
                alert(rowIdText);
            }
            this.del.forEach(btn=>{
                btn.addEventListener('click',delClick);
            });
        }
    }
    actions.listen();
</script>
