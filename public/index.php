<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use App\Database;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\BugTask;
use App\Models\FeatureTask;

use App\Repository\UserRepository;
use App\Repository\ProjectRepository;
use App\Repository\TaskRepository;

$connection = new Database();
$pdo = $connection->getConnection();

$userRepo = new UserRepository($pdo);
$taskRepo = new TaskRepository($pdo);
$projectRepo = new ProjectRepository($pdo);


var_dump($taskRepo->findAll());