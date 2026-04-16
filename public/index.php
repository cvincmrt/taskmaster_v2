<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use App\Database;
use App\Models\User;
use App\Repository\UserRepository;

$connection = new Database();
$pdo = $connection->getConnection();

$userRepo = new UserRepository($pdo);

$user = $userRepo->findByUsername("martin");

if ($user) {
    echo "Užívateľ nájdený: " . $user->getUsername() . " (Rola: " . $user->getRole() . ")<br>";
    
    // 2. Overíme heslo (toto je ten hlavný test!)
    if ($user->passwordVerify("martin")) {
        echo "Heslo je správne. Vitaj!";
    } else {
        echo "Nesprávne heslo.";
    }
} else {
    echo "Užívateľ neexistuje.";
}


