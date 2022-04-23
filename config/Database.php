<?php

class Database
{
    private string $host = 'localhost';
    private string $db_Name = 'php_shopping_cart';
    private string $user = 'root';
    private string $password = '';
    public $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_Name, $this->user, $this->password);
        } catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}