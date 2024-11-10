<?php
    function Html(): Html{
        return new Html();
    }
    function Sql(): Sql{
        return new Sql();
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
    function Delete(string $id):Delete{
        return new Delete($id);
    }