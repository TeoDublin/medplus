<?php
    function Html(): Html{
        return new Html();
    }
    function Sql(): Sql{
        return new Sql();
    }
    function Utenti(): Utenti{
        return new Utenti();
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
    function Clienti():Clienti{
        return new Clienti();
    }
    function Prenotazioni():Prenotazioni{
        return new Prenotazioni();
    }
    function Planning():Planning{
        return new Planning();
    }
    function Select(string $select):Select{
        return new Select($select);
    }
    function Insert(array $insert):Insert{
        return new Insert($insert);
    }
    function Update(string $table):Update{
        return new Update($table);
    }