<?php
    class Terapisti extends Base{
        protected array $tables=[
            'terapisti'=>'t'
        ];
        protected array $fields=[
            't_id'=>'t.id',
            't_terapista'=>'t.terapista'
        ];
        public function select($params):array{
            return parent::select($params);
        }
        public function update($params):void{
            parent::update($params);
        }
    }