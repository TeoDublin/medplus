<?php 
    class Delete{
        private $id;
        public function __construct(string $id){
            $this->id=$id;
        }
        public function from(string $table, $alias='id'){
            SQL()->query("DELETE FROM {$table} WHERE {$alias}={$this->id}");
        }
    }