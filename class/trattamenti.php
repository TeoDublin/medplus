<?php
    class Trattamenti extends Base{
        protected array $tables=[
            'trattamenti'=>'t'
        ];
        protected array $fields=[
            't_id'=>'t.id',
            't_trattamento'=>'t.trattamento'
        ];
        public function select($params):array{
            return parent::select($params);
        }
        public function update($params):void{
            parent::update($params);
        }
    }