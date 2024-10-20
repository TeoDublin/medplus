<?php
    class Trattamenti extends Base{
        protected string $table='trattamenti';
        protected array $fields=[
            'id',
            'categoria',
            'trattamento',
            'tipo',
            'prezzo'
        ];
    }