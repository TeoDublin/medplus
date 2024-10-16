<?php
    class Users extends Base{
        protected string $table='users';
        protected array $fields=[
            'id',
            'user',
            'email',
            'pasword',
            'template'
        ];
    }