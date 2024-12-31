<?php 
    function _select(){
        $select=$_REQUEST['cols']??'*';
        return $_REQUEST['id']?Select($select)->from($_REQUEST['table'])->where("id={$_REQUEST['id']}")->first():[];
    }
    function _element($col,$select,$is_last){
        $ret='';
        $name=ucfirst(str_replace('_',' ',$col['COLUMN_NAME']));
        preg_match('#(.+)\((.+)\)#',$col['COLUMN_TYPE'],$m);
        $type=$m[1]??$col['COLUMN_TYPE'];
        switch ($type) {
            case 'enum':{
                $enums=str_replace("'",'',explode(',',$m[2]));
                $value=$select[$col['COLUMN_NAME']]??'';
                $ret.="<div class=\"m-2 ".($is_last?'flex-fill':'w-50')."\">";
                $ret.="<label for=\"{$name}\" class=\"form-label \">{$name}</label>";
                $ret.="<select class=\"form-control text-center\" id=\"{$name}\" name=\"{$name}\" value=\"{$value}\">";
                    foreach($enums as $enum)$ret.="<option value=\"{$enum}\">{$enum}</option>";
                $ret.="</select>";
                $ret.="</div>";
                break;
            }
            case 'varchar':{
                $chars=(int)$m[2];
                if($is_last)$chars=100;
                elseif($chars>50)$chars=60;
                else $chars= $chars+10;
                $value=$select[$col['COLUMN_NAME']]??'';
                $ret.="<div class=\"m-2 ".($is_last?'flex-fill':'')."\" style=\"width:{$chars}%\">";
                $ret.="<label for=\"{$name}\" class=\"form-label \">{$name}</label>";
                $ret.="<input type=\"text\" class=\"form-control text-center\" id=\"{$name}\" name=\"{$name}\" value=\"{$value}\">";
                $ret.="</div>";
                break;
            }
            case 'double':{
                $value=$select[$col['COLUMN_NAME']]??'';
                $ret.="<div class=\"m-2 ".($is_last?'flex-fill':'w-30')."\">";
                $ret.="<label for=\"{$name}\" class=\"form-label \">{$name}</label>";
                $ret.="<input type=\"number\" class=\"form-control text-center\" id=\"{$name}\" name=\"{$name}\" value=\"{$value}\">";
                $ret.="</div>";
                break;
            }
            case 'timestamp':{
                $value=$select[$col['COLUMN_NAME']]??now('Y-m-d');
                $label=unformat_date($value);
                $ret.="<div class=\"m-2 ".($is_last?'flex-fill':'w-20')."\">";
                $ret.="<label for=\"{$name}\" class=\"form-label \">{$name}</label>";
                $ret.="<input type=\"text\" class=\"form-control text-center\" id=\"{$name}\" name=\"{$name}\" value=\"{$value}\" hidden/>";
                $ret.="<input type=\"text\" class=\"form-control text-center\" value=\"{$label}\" readonly disabled/>";
                $ret.="</div>";
                break;
            }
            case 'longtext':{
                $value=$select[$col['COLUMN_NAME']]??'';
                $ret.="<div class=\"m-2 ".($is_last?'flex-fill':'w-60')."\">";
                $ret.="<label for=\"{$name}\" class=\"form-label \">{$name}</label>";
                $ret.="<textarea rows=\"1\" type=\"text\" class=\"form-control text-center\" id=\"{$name}\" name=\"{$name}\" value=\"{$value}\">{$value}</textarea>";
                $ret.="</div>";
                break;
            }
            default:{
                $value=$select[$col['COLUMN_NAME']]??'';
                $ret.="<div class=\"m-2 ".($is_last?'flex-fill':'')."\">";
                $ret.="<label for=\"{$name}\" class=\"form-label \">{$name}</label>";
                $ret.="<input type=\"text\" class=\"form-control text-center\" id=\"{$name}\" name=\"{$name}\" value=\"{$value}\">";
                $ret.="</div>";
                break;
            }
        }
        return $ret;
    }
    function _size($columns){
        $size=count($columns);
        if($size<6)['class'=>'modal-sm','cols'=>1];
        elseif($size<8)$ret=['class'=>'modal-lg','cols'=>2];
        else $ret=['class'=>'modal-xl','cols'=>3];
        return $ret;
    }
    $chek_columns=SQL()->columns($_REQUEST['table']);
    if($_REQUEST['cols']){
        $columns=[];
        foreach ($chek_columns as $value) {
            if(in_array($value['COLUMN_NAME'],$_REQUEST['cols'])){
                $columns[]=$value;
            }
        }
    }
    else $columns=$chek_columns;
    $size=_size($columns);
?>
<div class="modal bg-dark bg-opacity-50" id="<?php echo $_REQUEST['id_modal'];?>" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog <?php echo $size['class'];?> p-0">
        <div class="modal-content p-0">
            <div class="modal-header">
                <h4><?php echo $_REQUEST['header'];?></h4>
                <button type="button" class="btn-resize" aria-hidden="true" onclick="resize('#<?php echo $_REQUEST['id_modal'];?>')"></button>
                <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <div class="p-0"><?php 
                    $cols=$col=$size['cols'];
                    $select=_select();
                    foreach($columns as $column){
                        if($column['COLUMN_NAME']!='id'){
                            if($col==$cols) echo "<div class='d-flex flex-row'>";
                            echo _element($column,$select, ($col==$cols||count($columns)==$col));
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
                <a href="#" class="btn btn-primary" onclick="window.modalHandlers['modal'].save(this,'<?php echo $_REQUEST['table'];?>')">Salva</a>
            </div>
        </div>
    </div>
    <?php modal_script('modal'); ?>
</div>