<?php

class sql {
    private $connection;

    public function __construct() {
        switch (_environment()) {
            case 'dev':
                $host='127.0.0.1';
                $user='teo';
                $pass='123testes'; 
                $db='medplus';
                break;
        }
        $this->connection = new mysqli($host, $user, $pass, $db);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }
    public function select($query) {
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function query($query) {
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
    }

    public function __destruct() {
        $this->connection->close();
    }
}