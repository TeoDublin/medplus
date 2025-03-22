<?php
    function Html(): Html{
        return new Html();
    }
    function Sql(): Sql{
        return new Sql();
    }
    function Template($key): Template{
        return new Template($key);
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
    function Enum(string $table,string $column):Enum{
        return new Enum($table,$column);
    }
    function Delete():Delete{
        return new Delete();
    }
    function Jwt():Jwt{
        return new Jwt();
    }
    function Session(){
        return Session::getInstance();
    }
    function Sedute():Sedute{
        return new Sedute();
    }