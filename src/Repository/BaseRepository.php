<?php

namespace App\Repository;

use PDO;
use PDOException;
use PDOStatement;

abstract class BaseRepository
{
    protected PDO $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    protected function query(string $sql, array $params = []) :bool|PDOStatement
    {
        try{
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        }
        catch(PDOException $e){
            return false;
        }
    }
}