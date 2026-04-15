<?php

namespace App;

use PDO;
use PDOException;

class UserRepository
{
    private ?PDO $db = null;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    //methods 

    public function save(User $user) :bool
    {
        try{
            $sql = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";

            $stmt = $this->db->prepare($sql);
            
            return  $stmt->execute([
                    ":username" => $user->getUsername(),
                    ":password" => $user->getPassword(),
                    ":role" => $user->getRole()
                    ]);
        }
        catch(PDOException $e){
            return false;
        }
    }

    public function findByUsername(string $username) :?User
    {
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([":username" => $username]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row){
            return null;
        }

        $user = new User($row["username"], "", $row["role"]);
        $user->setId((int)$row["id"]);
        $user->setRawPassword($row["password"]); 
        return $user;
   }
}
