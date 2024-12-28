<?php 
    function _element($col){
        $ret='';
        switch ($col['COLUMN_TYPE']) {
            case 'varchar(10)':
            case 'varchar(20)':
            case 'timestamp':{
                $ret.="<div class=\"m-1 w-20\">";
                $ret.="<label for=\"{$col['COLUMN_NAME']}\" class=\"form-label\">{$col['COLUMN_NAME']}</label>";
                $ret.="<input type=\"text\" class=\"form-control\" id=\"{$col['COLUMN_NAME']}\" name=\"{$col['COLUMN_NAME']}\" value=\"\">";
                $ret.="</div>";
                break;
            }
            case 'longtext':{
                $ret.="<div class=\"m-1 flex-fill\">";
                $ret.="<label for=\"{$col['COLUMN_NAME']}\" class=\"form-label\">{$col['COLUMN_NAME']}</label>";
                $ret.="<textarea rowspan=\"1\" type=\"text\" class=\"form-control\" id=\"{$col['COLUMN_NAME']}\" name=\"{$col['COLUMN_NAME']}\" value=\"\"></textarea>";
                $ret.="</div>";
                break;
            }
            default:{
                $ret.="<div class=\"m-1 flex-fill\">";
                $ret.="<label for=\"{$col['COLUMN_NAME']}\" class=\"form-label\">{$col['COLUMN_NAME']}</label>";
                $ret.="<input type=\"text\" class=\"form-control\" id=\"{$col['COLUMN_NAME']}\" name=\"{$col['COLUMN_NAME']}\" value=\"\">";
                $ret.="</div>";
                break;
            }
        }
        return $ret;
    }
?>
<div class="modal bg-dark bg-opacity-50" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content px-3 text-center">
            <div class="modal-header">
                <h4><?php echo $_REQUEST['header'];?></h4>
                <button type="button" class="btn-resize" aria-hidden="true" onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="p-2"><?php 
                    $cols=$col=$_REQUEST['cols'];
                    foreach(SQL()->columns($_REQUEST['table']) as $column){
                        if($column['COLUMN_NAME']!='id'){
                            if($col==$cols) echo "<div class='d-flex flex-row'>";
                            echo _element($column);
                            $col--;
                            if($col==0){
                                echo "</div>";
                                $col=$cols;
                            } 
                        }
                    }
                    if($col>0&&$col!=$cols)echo "</div>";
                    ?>
                </div>
            </div>
            <div class="modal-footer">
            <a href="#" class="btn btn-outline-dark">Close</a>
            <a href="#" class="btn btn-primary">Save changes</a>
            </div>
        </div>
    </div>
</div>