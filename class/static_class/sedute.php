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
                    Update('percorsi_terapeutici_sedute')->set($params)->where("id_percorso={$id_percorso} AND id_combo={$id_combo} AND `index`={$index}");
                }
                else{
                    Insert($params)->into('percorsi_terapeutici_sedute');
                }
            }            
        }
    }