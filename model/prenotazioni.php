<?php
    class Prenotazioni extends Base{
        protected string $table='prenotazioni';
        protected array $fields=[
            'id',
            'id_cliente',
            'id_trattamento',
            'tipo_sezioni'
        ];
    }