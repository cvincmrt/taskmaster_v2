<?php

namespace App\Repository;

use PDO;
class TaskRepository
{
    private PDO $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }
    
}