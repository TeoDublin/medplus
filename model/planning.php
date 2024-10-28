<?php
    class Planning extends Base{
        protected string $table='planning';
        protected array $fields=[
            'id',
            'row',
            'data',
            'ora',
            'id_terapista',
            'id_cliente'
        ];
    }