<?php 
class Update{
    private string $table;
    private string $set;
    private string $where;
    public function __construct(string $table){
        $this->table=$table;
    }
    public function set(array $set){
        $_set=[];
        foreach ($set as $key => $value){
            if(preg_match('#([0-9]{2})\/([0-9]{2})\/([0-9]{4})#',$value,$m))$value="{$m[3]}-{$m[2]}-{$m[1]}";
            $value=str_replace("'","\'",$value);
            $value=$value?"'{$value}'":'NULL';
            $_set[]="`{$key}`={$value}";

        } 
        $this->set=implode(',',$_set);
        return $this;
    }
    public function where(string $where){
        $this->where=$where;
        SQL()->query("UPDATE `{$this->table}` SET {$this->set} WHERE {$this->where}");
        return $this;
    }
}