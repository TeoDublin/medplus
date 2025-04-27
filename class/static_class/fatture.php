<?php 
    require_once __DIR__.'/../../includes/functions.php';
    Class Fatture{
        private function map():array{
            return [
                'id'=>['col'=>'id'],
                'Nominativo'=>['col'=>'nominativo','type'=>'dont_save'],
                'Numero'=>['col'=>'index'],
                'Stato Fattura'=>['col'=>'stato','type'=>'enum'],
                'Data Fattura'=>['col'=>'data','type'=>'date'],
                'Importo'=>['col'=>'importo','type'=>'double'],
                'Metodo di pagamento' =>['col'=>'metodo','type'=>'enum'],
                'Fatturato da'=>['col'=>'fatturato_da','type'=>'enum'],
                'Confermato dal Commercialista'=>['col'=>'confermato_dal_commercialista','type'=>'bool'],
                'link'=>['col'=>'link','type'=>'dont_save'],
            ];
        }

        public function map_out($data):array{
            $ret=[];
            foreach($this->map() as $key=>$value){
                $ret[$key]=match($value['type']??'text'){
                    'date'=>unformat_date($data[$value['col']],''),
                    'bool'=>($data[$value['col']]?'Si':'No'),
                    default=>$data[$value['col']]
                };
            }
            return $ret;
        }

        private $enums_list = [];
        private function enum($col_in, $value) {
            if (!isset($this->enums_list[$col_in])) {
                $list=Enum('fatture', $col_in)->list;
                $this->enums_list[$col_in] = $list;
            }
            $current_list=$this->enums_list[$col_in];
            if (in_array($value, $current_list)) {
                return $value;
            }
            return ['error' => "Valore {$value} non è valido"];
        }
        
        public function map_in($data):array{
            $ret=[];
            foreach($this->map() as $key=>$value){
                if(($val=$data[$key])){
                    $type=$value['type']??'text';
                    if($type=='dont_save');
                    else{
                        $v=match($type){
                            'date'=>format_date($val,''),
                            'double'=>str_replace(',','.',$val),
                            'enum'=>$this->enum($value['col'],$val),
                            'bool'=>($val=='Si'?1:0),
                            default=>$val
                        };
                        if($v!==null){
                            if(isset($v['error']))$ret['has_error']=true;
                            $ret[$value['col']]=$v;
                        }
                    }
                }
            }
            return $ret;
        }

    }