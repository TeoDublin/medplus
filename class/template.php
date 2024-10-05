<?php
    class Template{
        public string $theme;
        public array $images;
        public function __construct($key){
            $this->theme=$key;
            $this->images = [
                'login'=> root_path("/assets/images/login-{$key}.svg")
            ];
        }
    }