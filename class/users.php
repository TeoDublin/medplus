<?php
    class Users extends Base{
        protected array $tables=[
            'users'=>'u'
        ];
        protected array $fields=[
            'u_id'=>'u.id',
            'u_user'=>'u.user',
            'u_email'=>'u.email',
            'u_pasword'=>'u.pasword',
            'u_template'=>'u.template'
        ];
        public function select($params):array{
            return parent::select($params);
        }
        public function select_for_table($params):ResultForTable{
            $limit=$params['limit']??=10;
            unset($params['limit']);
            $select=$params['select'];
            $params['select']='count';
            $total=parent::first($params)['count'];
            $params['offset']=$offset=($_REQUEST['pagination']*$limit)??0;
            $params['limit']=$limit;
            $params['select']=$select;
            $result=parent::select($params);
            return new ResultForTable($result,$total,$offset,$limit);
        }
        public function update($params):void{
            parent::update($params);
        }
    }