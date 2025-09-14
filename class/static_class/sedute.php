<?php 
    require_once __DIR__.'/../../includes/functions.php';
    Class Sedute{
        private $enums_list = [];

        private function map():array{
            return [
                'id'=>['col'=>'id'],
                'Nominativo'=>['col'=>'nominativo','type'=>'dont_save'],
                'Portato Da'=>['col'=>'portato_da','type'=>'dont_save'],
                'Terapista'=>['col'=>'terapista','type'=>'dont_save'],
                'Trattamenti'=>['col'=>'trattamenti','type'=>'dont_save'],
                'Acronimo'=>['col'=>'acronimo','type'=>'dont_save'],
                'Prezzo'=>['col'=>'prezzo','type'=>'dont_save'],
                'Stato Seduta'=>['col'=>'stato_seduta','type'=>'dont_save'],
                'Data Seduta'=>['col'=>'data_seduta','type'=>'dont_save'],
                'Stato Pagamento'=>['col'=>'stato_pagamento','type'=>'dont_save'],
                'Valore Saldato'=>['col'=>'saldato','type'=>'dont_save'],
                'Data Pagamento'=>['col'=>'data_pagamento','type'=>'dont_save'],
                'Percentuale Terapista'=>['col'=>'percentuale_terapista'],
                'Saldo Terapista'=>['col'=>'saldo_terapista','type'=>'double'],
                'Saldato Terapista'=>['col'=>'saldato_terapista','type'=>'double'],
                'Stato Pagamento Terapista'=>['col'=>'stato_saldato_terapista','type'=>'enum'],
                'Data Pagamento al Terapista'=>['col'=>'data_saldato_terapista','type'=>'date']
            ];
        }

        public function map_out($data):array{
            $ret=[];
            foreach($this->map() as $key=>$value){
                $ret[$key]=$data[$value['col']];
            }
            return $ret;
        }

        private function _enum($col_in, $value) {
            if (!isset($this->enums_list[$col_in])) {
                $list=Enum('percorsi_terapeutici_sedute', $col_in)->list;
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
                    if($type=='dont_save')continue;
                    else{
                        $v=match($type){
                            'date'=>format_date($val,''),
                            'double'=>str_replace(',','.',$val),
                            'enum'=>$this->_enum($value['col'],$val),
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