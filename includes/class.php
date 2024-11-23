<?php
    function Html(): Html{
        return new Html();
    }
    function Sql(): Sql{
        return new Sql();
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
    /**
     * Creates a new Delete object with the given ID.
     *
     * @param string $id The ID of the record to delete.
     * @return Delete The Delete object for chaining.
     */
    function Delete(string $id):Delete{
        return new Delete($id);
    }