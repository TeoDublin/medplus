<?php 
    class Select{
        protected $select;
        protected $from;
        protected $left_join;
        protected $where;
        protected $query;
        public function __construct(string $select){
            $this->select=$this->where=$this->query='';
            $this->left_join=[];
            $this->select=$select;
        }
        public function from(string $table, string $alias){
            $this->from="{$table} {$alias}";
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
            $query="SELECT {$this->select} FROM {$this->from}";
            if(!empty($this->left_join))$query.=implode('',$this->left_join);
            if(!empty($this->where))$query.=" WHERE {$this->where}";
            return SQL()->select($query);
        }
        public function first():array{
            $ret=$this->get();
            return $ret[0] ?? [];
        }
        public function col(string $col):string|null{
            return $this->first()[$col]??null;
        }
    }