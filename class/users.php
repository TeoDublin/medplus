<?php
    class Users extends Base{
        protected array $tables=[
            'users'=>'u',
            'profili'=>'p'
        ];
        protected array $fields=[
            'u_id'=>'u.id',
            'u_user'=>'u.user',
            'u_email'=>'u.email',
            'u_pasword'=>'u.pasword',
            'u_template'=>'u.template',

            'p_id'=>'p.id',
            'p_profili'=>'p.profili'
        ];
        public function select($params):array{
            return parent::select($params);
        }
        public function update($params):void{
            parent::update($params);
        }
    }