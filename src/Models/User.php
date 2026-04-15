<?php

namespace App\Models;

class User
{
    private ?int $id = null;
    private string $username;
    private string $password;
    private string $role; // admin,manager,worker default worker

    public function __construct(string $username,string $password, string $role = "worker", bool $isAlreadyHashed = false)
    {
        $this->username = $username;
        $this->role = $role;
        $this->password = $isAlreadyHashed ? $password : password_hash($password, PASSWORD_DEFAULT);
    }
     
    // getters *****************************

    public function getUsername() :string
    {
        return $this->username;
    }

    public function getPassword() :string
    {
        return $this->password;
    }

    public function getRole() :string
    {
        return $this->role;
    }

    //setters *****************************

    public function setId(int $id) :void
    {
        $this->id = $id;
    }

    //verify method ***********************

    public function passwordVerify(string $plainPassword) :bool
    {
        return password_verify($plainPassword, $this->password);
    }

}