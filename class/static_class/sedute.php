<?php 
    require_once __DIR__.'/../../includes/functions.php';
    Class Sedute{
        private function _percorsi_terapeutici_sedute($id_percorso,$id_combo,$index){
            return Select('*')
                ->from('percorsi_terapeutici_sedute')
                ->where("id_percorso={$id_percorso}")
                ->and("id_combo={$id_combo}")
                ->and("`index`={$index}")
                ->first_or_false();
        }
        
        private function _view_pagamenti($id_percorso){
            return (double)Select('*')
                ->from('view_pagamenti')
                ->where("origine='trattamenti' AND id={$id_percorso}")
                ->col('saldato');
        }

        private function _view_percorsi($id_percorso){
            $ret=Select('*')
                ->from('view_percorsi')
                ->where("id={$id_percorso}")
                ->first();
            return [(double)$ret['prezzo'],(int)$ret['sedute'],$ret['id_cliente'],$ret['id_combo']];
        }

        private function _update_payment($data_pagamento,$tipo_pagamento,$percorsi_terapeutici_sedute,$stato_pagamento){
            if(!$tipo_pagamento)return [];
            elseif($stato_pagamento=='Pendente')return ['data_pagamento'=>'','tipo_pagamento'=>''];
            elseif($percorsi_terapeutici_sedute){
                if($percorsi_terapeutici_sedute['stato_pagamento']!='Saldato')
                    return ['data_pagamento'=>$data_pagamento??now('Y-m-d'),'tipo_pagamento'=>$tipo_pagamento??now('Y-m-d')];
                
                else return [];
            }
            else return [];
        }

        public function refresh($id_percorso,$data_pagamento=null,$tipo_pagamento=null){
            [$prezzo,$sedute,$id_cliente,$id_combo]=$this->_view_percorsi($id_percorso);
            $prezzo_a_seduta=round((double)$prezzo/(double)$sedute,2);
            $saldato_total=$this->_view_pagamenti($id_percorso);
            $prezzo_calc=($prezzo_a_seduta*$sedute);
            for ($i=0; $i < $sedute; $i++) { 
                $index=$i+1;
                $prezzo_a_seduta=$index==$sedute&&$prezzo>$prezzo_calc?$prezzo_a_seduta+($prezzo-$prezzo_calc):$prezzo_a_seduta;
                if($saldato_total>=$prezzo_a_seduta){
                    $saldato=$prezzo_a_seduta;
                    $saldato_total-=$prezzo_a_seduta;
                    $stato_pagamento='Saldato';
                }
                elseif($saldato_total>0){
                    $saldato=$saldato_total;
                    $saldato_total=0;
                    $stato_pagamento='Parziale';
                }
                else{
                    $saldato=0;
                    $stato_pagamento='Pendente';
                }
                $percorsi_terapeutici_sedute=$this->_percorsi_terapeutici_sedute($id_percorso,$id_combo,$index);
                $params=array_merge([
                    'index'=>$index,
                    'id_cliente'=>$id_cliente,
                    'id_percorso'=>$id_percorso,
                    'id_combo'=>$id_combo,
                    'prezzo'=>$prezzo_a_seduta,
                    'saldato'=>$saldato,
                    'stato_pagamento'=>$stato_pagamento
                ],$this->_update_payment($data_pagamento,$tipo_pagamento,$percorsi_terapeutici_sedute,$stato_pagamento));
                if($percorsi_terapeutici_sedute){
                    if($params['stato_pagamento']=='Pendente'){
                        $params['data_pagamento']='';
                        $params['tipo_pagamento']='';
                    }
                    Update('percorsi_terapeutici_sedute')->set($params)->where("id_percorso={$id_percorso} AND id_combo={$id_combo} AND `index`={$index}");
                }
                else{
                    Insert($params)->into('percorsi_terapeutici_sedute');
                }
            }            
        }

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
                $ret[$key]=match($value['type']??'text'){
                    'date'=>unformat_date($data[$value['col']],''),
                    default=>$data[$value['col']]
                };
            }
            return $ret;
        }

        private $enums_list = [];
        private function enum($col_in, $value) {
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
                    if($type=='dont_save');
                    else{
                        $v=match($type){
                            'date'=>format_date($val,''),
                            'double'=>str_replace(',','.',$val),
                            'enum'=>$this->enum($value['col'],$val),
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