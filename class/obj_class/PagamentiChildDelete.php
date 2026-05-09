<?php
require_once __DIR__ . '/../../includes/functions.php';

class PagamentiChildDelete
{
    public const PAYLOAD = [
        'id' => ['required' => true, 'type' => 'int|string']
    ];

    private array $save = [
        'data_creazione' => NULL,
        'data_pagamento' => NULL,
        'tipo_pagamento' => NULL,
        'stato_pagamento' => 'Pendente',
        'id_pagamenti' => NULL,
        'saldato' => 0,
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

    public function delete(): void
    {

        $id = $this->data['id'];

        $pagamenti = Select('*')
            ->from('pagamenti')
            ->where("id={$id}")
            ->first_or_false();

        if ( !$pagamenti) {
            throw new RuntimeException('Paggamento non trovato');
        }

        if ($pagamenti['tipo_pagamento'] === 'Fattura D.Z.') {
            $this->delete_fattura($pagamenti['id_fattura']);
        }
        
        $this->delete_standard($pagamenti['id']);
        
        Delete()->from('pagamenti')->where("id={$id}");
    }

    private function delete_fattura(int $id_fattura): void {

        $fatture = Select('*')
            ->from('fatture')
            ->where("id = {$id_fattura}")
            ->first_or_false();

        if (!$fatture) {
            throw new RuntimeException('Fattura non trovata');
        }

        Delete()
            ->from('fatture')
            ->where("id = {$fatture['id']}");

        Insert(['index' => $fatture['index']])
            ->ignore()
            ->into('fatture_eliminate');

    }

    private function delete_standard(int $id_pagamenti): void {

        $pagamenti_child = Select('*')
            ->from('pagamenti_child')
            ->where("id_pagamenti={$id_pagamenti}")
            ->get();

        foreach ($pagamenti_child as $pagamento) {

            switch ($pagamento['origine']) {

                case 'Trattamenti': {

                    Update('percorsi_terapeutici_sedute')
                        ->set($this->save)
                        ->where("id={$pagamento['id_origine_child']}");

                    break;
                }

                case 'Corsi': {

                    Update('corsi_pagamenti')
                        ->set($this->save)
                        ->where("id={$pagamento['id_origine_child']}");

                    break;
                }

                default: {
                    throw new InvalidArgumentException('Origine non gestita in pagamenti_child');
                }
            }
        }
    }
}