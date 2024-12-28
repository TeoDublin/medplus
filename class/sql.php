<?php

class Sql {
    private mysqli $connection;
    private $db;
    public function __construct() {
        switch (environment()) {
            case 'dev':
                $host='127.0.0.1';
                $user='medplus';
                $pass='123testes'; 
                $db='medplus';
                break;
            case 'prod':
                $host='localhost';
                $user='u482567801_medplus';
                $pass='Medplus2024'; 
                $db='u482567801_medplus';
                break;
        }
        $this->db=$db;
        try {
            $this->connection = new mysqli($host, $user, $pass, $db);
        } catch (mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function select(string $query):array {
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function query(string $query):void {
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
    }
    public function raw(string $query):array {
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }    
    public function insert_id(): int {
        return $this->connection->insert_id;
    }
    public function columns($table){
        return $this->raw("
            SELECT COLUMN_NAME, COLUMN_TYPE
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = '{$table}' AND TABLE_SCHEMA = '{$this->db}'
            ORDER BY ORDINAL_POSITION;        
        ");
    }
    public function __destruct() {
        $this->connection->close();
    }
}

Class ResultForTable{
    public array $result;
    public int $total;
    public int $offset;
    public int $limit;
    public int $pages;
    public function __construct(array $result, int $total, int $offset, int $limit){
        $this->result = $result;
        $this->total = $total;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->pages = ceil($total/$limit);
    }
}