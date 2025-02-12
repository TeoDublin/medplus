<?php 
class Html{
    public function alert(string $message):void{
        echo "<script>(function(){ alert('{$message}');})();</script>";
    }
    public function offset(){
        return (int)(isset($_REQUEST['pagination'])?$_REQUEST['pagination']:cookie('pagination',0));
    }
    public function pagination($result,$url):void{
        if(!str_contains($url,'?'))$url.='?';
        if($result->pages>1&&!$_REQUEST['search']){?>
            <div class="d-flex align-content-end">
                <div class="ms-auto flex-grow-0 me-3">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item" ><a class="page-link" href="<?php echo $url.'pagination='.($this->offset()==0?0:$this->offset()-1)?>" aria-label="indietro" ><span >&laquo;</span></a>
                            </li>
                            <?php 
                                for ($i=0; $i<=intdiv($result->total,$result->limit);$i++) {
                                    $active=($i==$this->offset())?'active':'';
                                    echo '<li class="page-item '.$active.'"><a class="page-link" href="'.$url.'pagination='.$i.'">'. $i+1 .'</a></li>';
                                }
                            ?>
                            <li class="page-item">
                                <a class="page-link" href="<?php echo $url.'pagination='.($this->offset()==$result->pages-1?$result->pages-1:$this->offset()+1)?>" aria-label="Next">
                                    <span >&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>            
                </div>
            </div>
            <?php
        }
    }
}
