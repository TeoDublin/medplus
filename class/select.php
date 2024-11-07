<?php 
    class Select{
        protected $select;
        protected $from;
        protected $left_join;
        protected $where;
        protected $query;
        protected $orderby;
        public function __construct(string $select){
            $this->select=$this->where=$this->query='';
            $this->left_join=[];
            $this->select=$select;
        }
        public function from(string $table, $alias='x'){
            $this->from="`{$table}` {$alias}";
            return $this;
        }
        public function left_join(string $left_join){
            $this->left_join[]=" LEFT JOIN {$left_join} ";
            return $this;
        }
        public function where(string $where){
            $this->where=$where;
            return $this;
        }
        public function and(string $and){
            $this->where.=" and {$and}";
            return $this;
        }
        public function get(): array{
            if (preg_match_all("#\*(.+?)\*#", $this->select, $matches)) {
                foreach ($matches[1] as $table) {
                    $ret=SQL()->select("SELECT CONCAT('`',GROUP_CONCAT(COLUMN_NAME SEPARATOR '`,`'),'`') as cols FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '{$table}' AND COLUMN_NAME != 'id'");
                    $this->select=str_replace("*{$table}*",$ret[0]['cols'],$this->select);
                }   
            }
            $query="SELECT {$this->select} FROM {$this->from}";
            if(!empty($this->left_join))$query.=implode('',$this->left_join);
            if(!empty($this->where))$query.=" WHERE {$this->where}";
            if(!empty($this->orderby))$query.=" ORDER BY {$this->orderby}";
            return SQL()->select($query);
        }
        public function first():array{
            $ret=$this->get();
            return $ret[0] ?? [];
        }
        public function first_or_false(){
            $ret=$this->get();
            return $ret[0] ?? false;
        }
        public function col(string $col):string|null{
            return $this->first()[$col]??null;
        }
        public function orderby(string $orderby){
            $this->orderby=$orderby;
            return $this;
        }
        public function get_or_false(){
            $ret=$this->get();
            return count($ret)>0?$ret:false;
        }
    }