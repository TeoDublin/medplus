<?php 
class Html{
    public function alert(string $message):void{
        echo "<script>(function(){ alert('{$message}');})();</script>";
    }
    public function table(array $thead, ResultForTable $body, array $actions=[]):void{?>
        <div class="card-body d-flex flex-column">
            <div class="p-2 border my-1" style="border-bottom: 0px!important;border-radius: 10px 10px 0 0;">
                <table class="table table-striped border-0">
                    <thead>
                        <tr class="align-middle">
                            <th scope="col" rowspan="2" hidden="true">#</th>
                            <?php
                                foreach ($thead as $col) echo '<th scope="col" class="text-center" rowspan="2">'.$col.'</th>';
                                if(!empty($actions)) echo '<th scope="col" colspan="'.count($actions)+1 .'" class="text-center">Azioni</th>';
                            ?>
                        </tr>
                        <tr>
                            <?php foreach($actions as $action=>$label) echo '<th scope="col" class="text-center">'.$label.'</th>';?>
                        </tr>
                    </thead>
                    <tbody><?php
                        foreach ($body->result  as $row) {
                            echo '<tr class="table-row"><th scope="row" id="row_id" hidden=true>'.$row['id'].'</th>';
                            unset($row['id']);
                            foreach($row as $td)echo '<td scope="col" class="text-center">'.$td.'</td>';
                            foreach ($actions as $action=>$label) {
                                echo match($action){
                                    'del'=>'<td class="text-center action-del" title="'.$label.'">'.icon('bin.svg').'</td>',
                                    'edit'=>'<td class="text-center action-edit" title="'.$label.'">'.icon('edit.svg').'</td>',
                                };
                            }
                            echo '</tr>';
                        }?>
                    </tbody>
                </table>
            </div>
            <?php if($body->pages>1){?>
                <div class="ms-auto flex-grow-0">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item" ><a class="page-link" href="<?php echo $_SERVER['SCRIPT_NAME'].'?pagination='.($_REQUEST['pagination']==0?0:$_REQUEST['pagination']-1)?>" aria-label="indietro" ><span aria-hidden="true">&laquo;</span></a>
                            </li>
                            <?php 
                                for ($i=0; $i<intdiv($body->total,$body->limit);$i++) {
                                    $active=($i==$_REQUEST['pagination']??0)?'active':'';
                                    echo '<li class="page-item '.$active.'"><a class="page-link" href="'.$_SERVER['SCRIPT_NAME'].'?pagination='.$i.'">'. $i+1 .'</a></li>';
                                }
                            ?>
                            <li class="page-item">
                                <a class="page-link" href="<?php echo $_SERVER['SCRIPT_NAME'].'?pagination='.($_REQUEST['pagination']==$body->pages-1?$body->pages-1:$_REQUEST['pagination']+1)?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>            
                </div><?php
            }?>
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
        </script><?php 
    }
}
