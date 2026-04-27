<?php 
require_once __DIR__.'/../../includes/functions.php';

class PagamentiChild {

    public const PAYLOAD = [
        'valore' => ['required' => true, 'type' => 'float'],
        'inps' => ['required' => false, 'type' => 'float', 'default' => 0],
        'bollo' => ['required' => false, 'type' => 'float', 'default' => 0],
        'id_cliente' => ['required' => true, 'type' => 'int|string'],
        'tipo_pagamento' => ['required' => true, 'type' => 'string'],
        'metodo' => ['required' => true, 'type' => 'string'],
        'percorsi' => ['required' => true, 'type' => 'array'],
        'data_creazione' => ['required' => true, 'type' => 'string'],
        'note' => ['required' => false, 'type' => 'string', 'default' => null],
        'fattura_aruba' => ['required' => false, 'type' => 'string', 'default' => null],
        'id_fattura' => ['required' => false, 'type' => 'int|string', 'default' => null],
    ];

    private array $data;

    public function __construct(array $params) {
        try {
            $this->data = resolve_payload($params, self::PAYLOAD);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function save(): void {

        $valore = $this->data['valore'];
        $inps = $this->data['inps'];
        $bollo = $this->data['bollo'];
        $id_cliente = $this->data['id_cliente'];
        $tipo_pagamento = $this->data['tipo_pagamento'];
        $metodo = $this->data['metodo'];
        $percorsi = $this->data['percorsi'];
        $data_creazione = $this->data['data_creazione'];
        $note = $this->data['note'];
        $fattura_aruba = $this->data['fattura_aruba'];
        $id_fattura = $this->data['id_fattura'];

        $voucher = ($tipo_pagamento === 'Contanti' && $metodo === 'Contanti') ? 'no' : 'si';
        $stato_pagamento = $metodo === 'Bonifico' ? 'Pendente' : 'Saldato';
        $data_pagamento = $metodo === 'Bonifico' ? NULL : $data_creazione;

        $id_pagamenti = Insert([
            'id_cliente' => $id_cliente,
            'tipo_pagamento' => $tipo_pagamento,
            'metodo' => $metodo,
            'data_creazione' => $data_creazione,
            'data_pagamento' => $data_pagamento,
            'imponibile' => $valore,
            'inps' => $inps,
            'bollo' => $bollo,
            'stato' => $stato_pagamento,
            'totale' => ($valore + $inps + $bollo),
            'voucher' => $voucher,
            'fattura_aruba' => $fattura_aruba,
            'id_fattura' => $id_fattura
        ])->into('pagamenti')->get();

        foreach ($percorsi as $value) {

            if ($valore <= 0) break;

            $obj = Select('*')->from($value['view'])->where("id={$value['id']}")->first();

            if (!$obj) {
                throw new RuntimeException("Record non trovato");
            }

            $prezzo = (float) $obj['prezzo'];

            $save = [
                'data_creazione' => $data_creazione,
                'data_pagamento' => $data_pagamento,
                'tipo_pagamento' => $tipo_pagamento,
                'stato_pagamento' => $stato_pagamento,
                'id_pagamenti' => $id_pagamenti,
                'saldato' => $prezzo 
            ];

            switch ($value['view']) {

                case 'corsi_pagamenti':{

                    $origine = 'Corsi';
                    $id_origine = $obj['id_corso'];
                    $id_origine_child = $obj['id'];

                    Update('corsi_pagamenti')
                        ->set($save)
                        ->where("id={$obj['id']}");

                    break;

                }

                case 'view_sedute':{

                    $origine = 'Trattamenti';
                    $id_origine = $obj['id_percorso'];
                    $id_origine_child = $obj['id'];

                    Update('percorsi_terapeutici_sedute')
                        ->set($save)
                        ->where("id={$obj['id']}");

                    break;
                }

                default:{
                    throw new InvalidArgumentException('View non gestita');
                }
                    
            }

            Insert([
                'id_pagamenti' => $id_pagamenti,
                'id_cliente' => $id_cliente,
                'id_origine' => $id_origine,
                'id_origine_child' => $id_origine_child,
                'tipo_pagamento' => $tipo_pagamento,
                'origine' => $origine,
                'valore' => $prezzo,
                'data_creazione' => $data_creazione,
                'data_pagamento' => $data_pagamento,
                'metodo' => $metodo,
                'stato' => $stato_pagamento,
                'note' => $note,
                'fattura_aruba' => $fattura_aruba,
                'id_fattura' => $id_fattura
            ])->into('pagamenti_child');

            $valore = round($valore - $prezzo, 2);
        }
    }
}