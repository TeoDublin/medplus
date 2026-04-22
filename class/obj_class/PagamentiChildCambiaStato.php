<?php
require_once __DIR__ . '/../../includes/functions.php';

class PagamentiChildCambiaStato
{
    public const PAYLOAD = [
        'id' => ['required' => true, 'type' => 'int|string'],
        'stato_pagamento' => ['required' => true, 'type' => 'string'],
        'data_pagamento' => ['required' => false, 'type' => 'string'],
    ];

    private array $data;

    public function __construct(array $params)
    {
        try {
            $this->data = resolve_payload($params, self::PAYLOAD);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function save(){
        
        $id = $this->data['id'];
        $stato_pagamento = $this->data['stato_pagamento'];
        $data_pagamento = $this->data['data_pagamento'] ?? NULL;

        $pagamenti = Select('*')
        ->from('pagamenti')
        ->where("id={$id}")
        ->first_or_false();

        if ( !$pagamenti) {
            throw new RuntimeException('Paggamento non trovato');
        }

        switch ($stato_pagamento) {

            case 'Saldato':{

                if(empty($data_pagamento)){
                    throw new Exception("Data Pagamento è obbligatoria", 1);
                }

                $save = [
                    'data_pagamento' => $data_pagamento,
                    'stato_pagamento' => $stato_pagamento,
                ];
                break;
            }

            case 'Pendente':{
                $save = [
                    'data_pagamento' => NULL,
                    'stato_pagamento' => $stato_pagamento,
                ];
                break;
            }
            
            default:{
                throw new Exception("stato_pagamento out of range", 1);
                break;
            }
        }

        $pagamenti_child = Select('*')
        ->from('pagamenti_child')
        ->where("id_pagamenti={$pagamenti['id']}")
        ->get();

        foreach ($pagamenti_child as $pagamento) {

            switch ($pagamento['origine']) {

                case 'Trattamenti': {

                    Update('percorsi_terapeutici_sedute')
                        ->set($save)
                        ->where("id={$pagamento['id_origine_child']}");

                    break;
                }

                case 'Corsi': {

                    Update('corsi_pagamenti')
                        ->set($save)
                        ->where("id={$pagamento['id_origine_child']}");

                    break;
                }

                default: {
                    throw new InvalidArgumentException('Origine non gestita in pagamenti_child');
                }
            }

            Update('pagamenti_child')
            ->set([
                'stato' => $stato_pagamento,
                'data_pagamento' => $data_pagamento
            ])
            ->where("id = {$pagamento['id']}");
        }

        Update('pagamenti')
        ->set([
            'stato' => $stato_pagamento,
            'data_pagamento' => $data_pagamento
        ])
        ->where("id = {$pagamenti['id']}");
    }
}