<?php

require_once __DIR__."/../init.php";

use App\User;
use App\Database;
use App\UserRepository;

$connection = new Database();
$pdo = $connection->getConnection();

$userRepo = new UserRepository($pdo);
/*$user = new User("martin","martin", "admin");

if($userRepo->save($user)){
    echo "user has been saved";
}else{
    echo "user not saved";
}*/

if($user = $userRepo->findByUsername("peter")){
    echo "user find";
    var_dump($user);

}else{
    echo "user not find";
}


