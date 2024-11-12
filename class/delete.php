<?php 
    class Delete{
        private $id;
        public function __construct(string $id){
            $this->id=$id;
        }
        public function from(string $table){
            SQL()->query("DELETE FROM {$table} WHERE id={$this->id}");
        }
    }