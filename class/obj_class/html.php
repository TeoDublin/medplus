<?php 
class Html{
    public function alert(string $message):void{
        echo "<script>(function(){ alert('{$message}');})();</script>";
    }
    public function offset(){
        return (int)(isset($_REQUEST['pagination'])?$_REQUEST['pagination']:cookie('pagination',0));
    }
    public function pagination($result, $url): void {
        if (!str_contains($url, '?')) $url .= '?';
        if ($result->pages > 1 && !$_REQUEST['search']) { ?>
            <div class="d-flex align-content-end">
                <div class="ms-auto flex-grow-0 me-md-3">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination ">
                            <li class="page-item">
                                <a class="page-link" href="<?php echo $url . 'pagination=' . ($this->offset() == 0 ? 0 : $this->offset() - 1); ?>" aria-label="indietro" >
                                    <span>&laquo;</span>
                                </a>
                            </li>
                            <?php
                            $total_pages = intdiv($result->total, $result->limit);
                            $current = $this->offset();
                            if ($total_pages > 6) {
                                for ($i = 0; $i < 3; $i++) {
                                    $active = ($i == $current) ? 'active' : '';
                                    echo '<li class="page-item ' . $active . '"><a class="page-link" href="' . $url . 'pagination=' . $i . '">' . ($i + 1) . '</a></li>';
                                }
                                echo '<li class="page-item disabled"><span class="page-link"><span class="d-block d-md-none">.</span><span class="d-none d-md-block">...</span></span></li>';
                                if($current>=3&&$current<($total_pages - 2)){
                                    $active = 'active';
                                    echo '<li class="page-item ' . $active . '"><a class="page-link" href="' . $url . 'pagination=' . $current . '">' . ($current +1). '</a></li>';
                                    echo '<li class="page-item disabled"><span class="page-link"><span class="d-block d-md-none">.</span><span class="d-none d-md-block">...</span></span></li>';
                                }
                                for ($i = $total_pages - 2; $i <= $total_pages; $i++) {
                                    $active = ($i == $current) ? 'active' : '';
                                    echo '<li class="page-item ' . $active . '"><a class="page-link" href="' . $url . 'pagination=' . $i . '">' . ($i + 1) . '</a></li>';
                                }
                            } else {
                                for ($i = 0; $i <= $total_pages; $i++) {
                                    $active = ($i == $current) ? 'active' : '';
                                    echo '<li class="page-item ' . $active . '"><a class="page-link" href="' . $url . 'pagination=' . $i . '">' . ($i + 1) . '</a></li>';
                                }
                            }
                            ?>
                            <li class="page-item">
                                <a class="page-link" href="<?php echo $url . 'pagination=' . ($this->offset() == $total_pages ? $total_pages : $this->offset() + 1); ?>" aria-label="Next">
                                    <span>&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        <?php
        }
    }
    
    public function pagination2($result, $url): void {
        if (!str_contains($url, '?')) $url .= '?';
        if ($result->pages > 1 && !$_REQUEST['search']) { ?>
            <div class="d-flex align-content-end">
                <div class="ms-auto flex-grow-0 me-md-3">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination ">
                            <li class="page-item">
                                <a class="page-link" href="<?php echo $url . 'pagination=' . ($this->offset() == 0 ? 0 : $this->offset() - 1); ?>" aria-label="indietro" >
                                    <span>&laquo;</span>
                                </a>
                            </li>
                            <?php
                            $total_pages = intdiv($result->total, $result->limit);
                            $current = $this->offset();
                            for ($i = 0; $i <= $total_pages; $i++) {
                                $active = ($i == $current) ? 'active' : '';
                                echo '<li class="page-item ' . $active . '"><a class="page-link" href="' . $url . 'pagination=' . $i . '">' . ($i + 1) . '</a></li>';
                            }
                            ?>
                            <li class="page-item">
                                <a class="page-link" href="<?php echo $url . 'pagination=' . ($this->offset() == $total_pages ? $total_pages : $this->offset() + 1); ?>" aria-label="Next">
                                    <span>&raquo;</span>
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
