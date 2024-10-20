<?php
    class Utenti extends Base{
        protected string $table='utenti';
        protected array $fields=[
            'id',
            'utente',
            'email',
            'password',
            'template'
        ];
    }