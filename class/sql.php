<?php

class Sql {
    private mysqli $connection;

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
                $user='medplus';
                $pass='Medplus2024'; 
                $db='u482567801_medplus';
                break;
        }
        $this->connection = new mysqli($host, $user, $pass, $db);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }
    public function select($query):array {
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function query($query):void {
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
    }
    public function __destruct() {
        $this->connection->close();
    }
}