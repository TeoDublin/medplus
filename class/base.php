<?php
    class Base{
        protected array $tables;
        protected array $fields;
        private string $table;
        private string $alias;
        private string $select;
        private string $where;
        private function _table(array $params):void{
            $this->table = $params['table'] ?? array_keys($this->tables)[0];
            $this->alias = $this->tables[$this->table];
            unset($params['table']);
        }
        private function _select(array $params):void{
            $this->select = implode(",",$params['select'] ??= $this->default_select());
            unset($params['select']);
        }
        private function _where(array $params):void{
            $this->where = $this->_parse_where($params);
        }

        public function select(array $params):array{
            $sql=Sql();
            $this->_table($params);
            $this->_select($params);
            $this->_where($params);
            $result=$sql->select("SELECT {$this->select} FROM {$this->table} {$this->alias} WHERE {$this->where}");
            return $result;
        }
        public function first($params):array{
            return $this->select($params)[0];
        }
        public function insert($table,$insert){
            
        }
        public function update($table,$join,$set,$where){
            
        }
        public function delete($table,$where){
            
        }
        public function default_select():array{
            return array_filter($this->fields,function($field){
                return substr($field,0,strlen($this->alias))===$this->alias;
            });
        }
        private function _parse_where($params):string{
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