<?php
    class users extends base{
        private $table;
        private $alias;
        private function _table($switch=false){
            switch ($switch) {
                default:
                    $this->table='users';
                    $this->alias='u';
                    break;
            }
        }
        private $fields=[
            'u_id'=>'u.id',
            'u_username'=>'u.username',
            'u_pasword'=>'pasword'
        ];
        public function select($params){
            $this->_table($params['table']);
            
        }
    }