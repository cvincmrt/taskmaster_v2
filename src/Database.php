<?php
namespace App;

use PDO;
use PDOException;

class Database
{
    private string $host = "localhost";
    private string $dbname = "taskmaster_v2";
    private string $user = "root";
    private string $password = "";
    private string $charset = "utf8mb4";

    private ?PDO $conn = null;

    public function getConnection() :?PDO
    {
        $dns = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
        try{
            $this->conn = new PDO($dns, $this->user, $this->password);
        }
        catch(PDOException $e){
            die($e->getMessage());                
        }

        return $this->conn;

    }
}