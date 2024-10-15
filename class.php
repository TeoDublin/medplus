<?php
    $files = glob(__DIR__ . '/class/*.php');
    foreach ($files as $file) require_once $file;

    function Html(): Html{
        return new Html();
    }
    function Sql(): Sql{
        return new Sql();
    }
    function Users(): Users{
        return new Users();
    }
    function Base(): Base{
        return new Base();
    }
    function Session():Session{
        return new Session();
    }
    function Template($key): Template{
        return new Template($key);
    }
    function Trattamenti():Trattamenti{
        return new Trattamenti();
    }
    function Terapisti():Terapisti{
        return new Terapisti();
    }