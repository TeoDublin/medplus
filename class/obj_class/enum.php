
<?php 
class Enum{
    public $list;
    public function __construct(string $table, string $column) {

        if(($ret = Session()->get("Enum_{$table}_{$column}"))){
            $this->list = $ret;
        }
        else{
            $result=Sql()->select("SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '{$table}' AND COLUMN_NAME = '{$column}'");
            $ret=str_replace("'",'',str_replace(')','',str_replace('enum(','',$result[0]['COLUMN_TYPE'])));
            $this->list=explode(',',$ret);
            Session()->set("Enum_{$table}_{$column}", $this->list);
        }

    }
    public function get(){
        return $this->list;
    }
}