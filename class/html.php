<?php 
class Html{
    public function alert(string $message):void{
        echo "<script>(function(){ alert('{$message}');})();</script>";
    }
    public function table(array $thead, ResultForTable $body, array $actions=[]):void{?>
        <div class="card-body d-flex flex-column">
            <div class="p-2">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <?php
                                foreach ($thead as $col) echo '<th scope="col">'.$col.'</th>';
                                if(!empty($actions)) echo '<th scope="col" colspan="'.count($actions)+1 .'" class="text-center">Azioni</th>';
                            ?>
                        </tr>
                    </thead>
                    <tbody><?php
                        foreach ($body->result  as $row) {
                            echo '<tr class="table-row"><th scope="row" id="row_id">'.$row['id'].'</th>';
                            unset($row['id']);
                            foreach($row as $td)echo "<td>{$td}</td>";
                            foreach ($actions as $action) {
                                echo match($action){
                                    'del'=>'<td class="text-center action-del" title="Elimina">'.icon('bin.svg').'</td>',
                                    'edit'=>'<td class="text-center action-edit" title="Modifica">'.icon('edit.svg').'</td>',
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
                                for ($i=0; $i<=intdiv($body->total,$body->limit);$i++) {
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
        </div><?php     
    }
}
