<?php
    class Base{
        protected array $tables;
        protected array $fields;
        private string $table;
        private string $alias;
        private string $select;
        private string $set;
        private string $where;
        private int $limit;
        private int $offset;
        private int $total;
        public function select(array $params):array{
            $sql=Sql();
            $this->_table($params);
            $this->_select($params);
            $this->_limit($params);
            $this->_offset($params);            
            $this->_where($params);
            $query="SELECT {$this->select} FROM {$this->table} {$this->alias} WHERE {$this->where}";
            if($this->limit)$query.=" LIMIT {$this->limit}";
            if($this->offset)$query.=" OFFSET {$this->offset}";            
            $result=$sql->select($query);
            return $result;
        }
        public function select_for_table($params):ResultForTable{
            $limit=$params['limit']??=10;
            unset($params['limit']);
            $select=$params['select'];
            $params['select']='count';
            $total=$this->first($params)['count'];
            $params['offset']=$offset=($_REQUEST['pagination']*$limit)??0;
            $params['limit']=$limit;
            $params['select']=$select;
            $result=$this->select($params);
            return new ResultForTable($result,$total,$offset,$limit);
        }
        public function first($params):array{
            $ret=$this->select($params);
            return count($ret)>0?$ret[0]:$ret;
        }
        public function insert($table,$insert){

        }
        public function update(array $params):void{
            $sql=Sql();
            $this->_table($params);
            $this->_set($params);
            $this->_where($params);
            $sql->query("UPDATE {$this->table} {$this->alias} SET {$this->set} WHERE {$this->where}");
        }
        public function delete(array &$params){
            
        }
        public function default_select():array{
            return array_filter($this->fields,function($field){
                return substr($field,0,strlen($this->alias))===$this->alias;
            });
        }
        private function _table(array &$params):void{
            $this->table = $params['table'] ?? array_keys($this->tables)[0];
            $this->alias = $this->tables[$this->table];
            unset($params['table']);
        }
        private function _select(array &$params):void{
            if($params['select']=='count')$this->select = "count({$this->alias}.id) as `count`";
            else{
                $select=$params['select'] ? $this->_filter($params['select']) : $this->default_select();
                $this->select = implode(",",  array_values($select));
            }
            unset($params['select']);
        }
        private function _limit(array &$params):void{
            if(isset($params['limit'])){
                $this->limit=(int)$params['limit'];
                unset($params['limit']);
            }
            else $this->limit=false;
        }
        private function _offset(array &$params):void{
            if(isset($params['offset'])){
                $this->offset=(int)$params['offset'];
                unset($params['offset']);
            }
            else $this->offset=false;
        }
        private function _filter(array $select):array{
            $ret=[];
            foreach($select as $key)$ret[$key]=$this->fields[$key];
            return $ret;
        }
        private function _set(array &$params):void{
            $set=[];
            foreach ($params['set'] as $key => $value) $set[]="{$this->fields[$key]}='{$value}'"; 
            $this->set=implode(',',$set);
            unset($params['set']);
        }
        private function _where(array &$params):void{
            $this->where = $this->_parse_where($params);
        }
        private function _parse_where(&$params):string{
            $conditions=[];
            foreach ($params as $field => $condition) {
                if(!is_array($condition))$conditions[]="{$this->fields[$field]}='{$condition}'";
                else{
                    foreach ($condition as $operator => $op_condition) {
                        $conditions[] = match ($operator) {
                            'eq' => "{$this->fields[$field]}='{$op_condition}'",
                            'neq' => "{$this->fields[$field]}<>'{$op_condition}'",
                            'in' => "{$this->fields[$field]} IN('" . implode("','", $op_condition) . "')",
                            'notin' => "{$this->fields[$field]} NOT IN('" . implode("','", $op_condition) . "')"
                        };
                    }
                }
            }
            if(empty($conditions))return '1=1';
            else return implode(" AND ",$conditions);
        }
    }