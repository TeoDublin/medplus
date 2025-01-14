<?php 
class Html{
    public function alert(string $message):void{
        echo "<script>(function(){ alert('{$message}');})();</script>";
    }
    public function pagination($result,$url):void{
        if($result->pages>1&&!$_REQUEST['search']){?>
            <div class="ms-auto flex-grow-0 me-3">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item" ><a class="page-link" href="<?php echo $url.'?pagination='.(cookie('pagination',0)==0?0:cookie('pagination',0)-1)?>" aria-label="indietro" ><span aria-hidden="true">&laquo;</span></a>
                        </li>
                        <?php 
                            for ($i=0; $i<=intdiv($result->total,$result->limit);$i++) {
                                $active=($i==cookie('pagination',0)??0)?'active':'';
                                echo '<li class="page-item '.$active.'"><a class="page-link" href="'.$url.'?pagination='.$i.'">'. $i+1 .'</a></li>';
                            }
                        ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo $url.'?pagination='.(cookie('pagination',0)==$result->pages-1?$result->pages-1:cookie('pagination',0)+1)?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>            
            </div><?php
        }
    }
}
