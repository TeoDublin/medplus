<?php 
    function _select(){
        return $_REQUEST['id']?Select('*')->from($_REQUEST['table'])->where("id={$_REQUEST['id']}")->first():[];
    }
    function _element($col,$select){
        $ret='';
        $name=ucfirst(str_replace('_',' ',$col['COLUMN_NAME']));
        
        switch ($col['COLUMN_TYPE']) {
            case 'varchar(10)':
            case 'varchar(20)':{
                $value=$select[$col['COLUMN_NAME']]??'';
                $ret.="<div class=\"m-1 w-20\">";
                $ret.="<label for=\"{$name}\" class=\"form-label\">{$name}</label>";
                $ret.="<input type=\"text\" class=\"form-control text-center\" id=\"{$name}\" name=\"{$name}\" value=\"{$value}\">";
                $ret.="</div>";
                break;
            }
            case 'timestamp':{
                $value=$select[$col['COLUMN_NAME']]??now('Y-m-d');
                $label=unformat_date($value);
                $ret.="<div class=\"m-1 w-20\">";
                $ret.="<label for=\"{$name}\" class=\"form-label\">{$name}</label>";
                $ret.="<input type=\"text\" class=\"form-control text-center\" id=\"{$name}\" name=\"{$name}\" value=\"{$value}\" hidden/>";
                $ret.="<input type=\"text\" class=\"form-control text-center\" value=\"{$label}\" readonly disabled/>";
                $ret.="</div>";
                break;
            }
            case 'longtext':{
                $value=$select[$col['COLUMN_NAME']]??'';
                $ret.="<div class=\"m-1 flex-fill\">";
                $ret.="<label for=\"{$name}\" class=\"form-label\">{$name}</label>";
                $ret.="<textarea rows=\"1\" type=\"text\" class=\"form-control text-center\" id=\"{$name}\" name=\"{$name}\" value=\"{$value}\">{$value}</textarea>";
                $ret.="</div>";
                break;
            }
            default:{
                $value=$select[$col['COLUMN_NAME']]??'';
                $ret.="<div class=\"m-1 flex-fill\">";
                $ret.="<label for=\"{$name}\" class=\"form-label\">{$name}</label>";
                $ret.="<input type=\"text\" class=\"form-control text-center\" id=\"{$name}\" name=\"{$name}\" value=\"{$value}\">";
                $ret.="</div>";
                break;
            }
        }
        return $ret;
    }
    function _size($columns){
        $size=count($columns);
        if($size<4)['class'=>'modal-sm','cols'=>1];
        elseif($size<8)$ret=['class'=>'modal-lg','cols'=>2];
        else $ret=['class'=>'modal-xl','cols'=>3];
        return $ret;
    }
    $columns=SQL()->columns($_REQUEST['table']);
    $size=_size($columns);
?>
<div class="modal bg-dark bg-opacity-50" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog <?php echo $size['class'];?>">
        <div class="modal-content px-3 text-center">
            <div class="modal-header">
                <h4><?php echo $_REQUEST['header'];?></h4>
                <button type="button" class="btn-resize" aria-hidden="true" onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="p-2"><?php 
                    $cols=$col=$size['cols'];
                    $select=_select();
                    foreach($columns as $column){
                        if($column['COLUMN_NAME']!='id'){
                            if($col==$cols) echo "<div class='d-flex flex-row'>";
                            echo _element($column,$select);
                            $col--;
                            if($col==0){
                                echo "</div>";
                                $col=$cols;
                            } 
                        }
                        elseif($select['id']) echo "<input type=\"text\" name=\"id\" value=\"{$select['id']}\" hidden/>";
                    }
                    if($col>0&&$col!=$cols)echo "</div>";
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['modal'].save(this,'<?php echo $_REQUEST['table'];?>')">Save changes</a>
            </div>
        </div>
    </div>
    <?php modal_script('modal'); ?>
</div>