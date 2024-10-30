<?php
    class Clienti extends Base{
        protected string $table='clienti';
        protected array $fields=[
            'id',
            'nominativo',
            'indirizzo',
            'cap',
            'citta',
            'cf',
            'telefono',
            'celulare',
            'email',
            'tipo',
            'portato_da',
            'data_inserimento',
            'prestazioni_precedenti',
            'notizie_cliniche',
            'note_trattamento'
        ];
    }