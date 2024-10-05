<?php
    class Users extends Base{
        protected array $tables=[
            'users'=>'u'
        ];
        protected array $fields=[
            'u_id'=>'u.id',
            'u_email'=>'u.email',
            'u_pasword'=>'u.pasword',
            'u_template'=>'u.template'
        ];
        public function select($params):array{
            return parent::select($params);
        }
    }