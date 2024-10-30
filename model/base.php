<?php
    class Base{
        protected array $fields;
        protected string $table;
        protected string $alias;
        private string $select;
        private string $set;
        private string $where;
        private int $limit;
        private int $offset;
        private string $orderby;
        public function select(array $params):array{
            $this->_alias();
            $this->_select($params);
            $this->_limit($params);
            $this->_offset($params);
            $this->_orderby($params);
            $this->_where($params);
            $query="SELECT {$this->select} FROM {$this->table} {$this->alias} WHERE {$this->where}";
            if($this->orderby)$query.=" ORDER BY {$this->orderby}";
            if($this->limit)$query.=" LIMIT {$this->limit}";
            if($this->offset)$query.=" OFFSET {$this->offset}";
            $result=Sql()->select($query);
            return $result;
        }
        public function insert(array $params):string{
            unset($params['id']);
            $keys=implode(',',array_map(fn($value)=>"`{$value}`",array_keys($params)));
            $values = implode(',', array_map(function($value) {
                if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $value)) {
                    $dateParts = explode('/', $value);
                    $value = "{$dateParts[2]}-{$dateParts[1]}-{$dateParts[0]}";
                }
                return "'{$value}'";
            }, $params));
            $sql=Sql();
            $sql->query("INSERT INTO {$this->table} ({$keys}) VALUES ({$values})");
            return $sql->insert_id();
        }
        public function update(array $params):void{
            $this->_alias();
            $id=$params['id'];
            unset($params['id']);
            $this->_set($params);
            Sql()->query("UPDATE {$this->table} {$this->alias} SET {$this->set} WHERE id = {$id}");
        }
        public function delete(string $id):void{
            $this->table;
            Sql()->query("DELETE FROM {$this->table} WHERE id={$id}");
        }
        public function select_for_table($params):ResultForTable{
            $limit=$params['limit']??=10;
            unset($params['limit']);
            $select=$params['select'] ?? $this->fields;
            $params['select']='count';
            $total=$this->first($params)['count'];
            $params['offset']=$offset=((int)cookie('pagination',0)*$limit)??0;
            $params['limit']=$limit;
            $params['select']=$select;
            $result=$this->select($params);
            return new ResultForTable($result,$total,$offset,$limit);
        }
        public function first($params):array{
            $ret=$this->select($params);
            return count($ret)>0?$ret[0]:$ret;
        }
        public function enum(string $column):array{
            $result=Sql()->select("SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '{$this->table}' AND COLUMN_NAME = '{$column}'");
            $ret=str_replace("'",'',str_replace(')','',str_replace('enum(','',$result[0]['COLUMN_TYPE'])));
            return explode(',',$ret);
        }
        private function _select(array &$params):void{
            if($params['select']=='count')$this->select = "count({$this->alias}.id) as `count`";
            else{
                $select=$params['select'] ??=array_map(fn($field)=>"{$this->alias}.{$field}",$this->fields);
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
        private function _orderby(array &$params):void{
            if(isset($params['orderby'])){
                $this->orderby=$params['orderby'];
                unset($params['orderby']);
            }
            else $this->orderby=false;
        }
        private function _set(array &$params):void{
            $set=[];
            foreach ($params as $key => $value){
                if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $value)) {
                    $dateParts = explode('/', $value);
                    $value = "{$dateParts[2]}-{$dateParts[1]}-{$dateParts[0]}";
                }
                $set[]="{$this->alias}.{$key}='{$value}'"; 
            }
            $this->set=implode(',',$set);
        }
        private function _where(array &$params):void{
            $this->where = $this->_parse_where($params);
        }
        private function _parse_where(&$params):string{
            $conditions=[];
            foreach ($params as $field => $condition) {
                if(!is_array($condition))$conditions[]="{$this->alias}.{$field}='{$condition}'";
                else{
                    foreach ($condition as $operator => $op_condition) {
                        $conditions[] = match ($operator) {
                            'eq' => "{$this->alias}.{$field}='{$op_condition}'",
                            'neq' => "{$this->alias}.{$field}<>'{$op_condition}'",
                            'in' => "{$this->alias}.{$field} IN('" . implode("','", $op_condition) . "')",
                            'notin' => "{$this->alias}.{$field} NOT IN('" . implode("','", $op_condition) . "')",
                            'like' => "{$this->alias}.{$field} LIKE '{$op_condition}'",
                        };
                    }
                }
            }
            if(empty($conditions))return '1=1';
            else return implode(" AND ",$conditions);
        }
        private function _alias($alias=null){
            $this->alias= $alias ?? substr($this->table,0,1);
        }
    }