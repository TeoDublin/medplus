<?php
    class Template{
        public string $theme;
        public array $images;
        public function __construct($key){
            $this->theme=$key;
            $this->images = [
                'login'=> image("login-{$key}.svg")
            ];
        }
    }