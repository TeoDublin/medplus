<?php 
    require_once __DIR__.'/../../includes/functions.php';
    Class Corsiplanning{
        private function __construct() {}
        public static function insert_corsi_planning($period,$giorni,$corso):void{
            foreach ($period as $date) {
                foreach($giorni as $day){
                    if ((int)$date->format('N') == $day['num']) { 
                        $data=$date->format('Y-m-d');
                        $where=[
                            'id_corso'=>$corso['id'],
                            'row_inizio'=>$day['inizio'],
                            'row_fine'=>$day['fine'],
                            'id_terapista'=>$corso['id_terapista'],
                            'data'=>$data,
                        ];
                        if(!Select('*')->from('corsi_planning')->where(parse_where($where))->get_or_false()){
                            Insert(array_merge($where,['motivo'=>$corso['corso']]))->into('corsi_planning')->flush();
                        }
                    }
                }
            }
        }
        public static function insert_corsi_pagamenti($start_date, $end_date, $scadenza, $corso_columns):void{
            $start = new DateTime($start_date);
            $end = new DateTime($end_date);
            while ($start <= $end) {
                $date=$start->format("Y-m-{$scadenza}");
                $corso_columns['scadenza']=$date;
                if(!Select('*')->from('corsi_pagamenti')->where(parse_where([
                        'id_cliente'=>$corso_columns['id_cliente'],
                        'id_corso'=>$corso_columns['id_corso'],
                        'scadenza'=>$corso_columns['scadenza'],
                    ]))->first_or_false()
                ){
                    Insert($corso_columns)->into('corsi_pagamenti')->flush();
                }
                $start->modify('+1 month');
            }
        }
    }