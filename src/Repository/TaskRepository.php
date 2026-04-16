<?php

namespace App\Repository;

use App\Models\Task;
use PDO;
class TaskRepository
{
    private PDO $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function save(Task $task) :bool
    {
        $sql = "INSERT INTO tasks (creator_id, assigned_to, project_id, title, status, type, priority) VALUES (:creator_id, :assigned_to, :project_id, :title, :status, :type, :priority)";

        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            ":creator_id" => $task->getCreatorId(),
            ":assigned_to" => $task->getAssignedTo(),
            ":project_id" => $task->getProjectId(),
            ":title" => $task->getTitle(),
            ":status" => $task->getStatus(),
            ":type" => $task->getType(),
            ":priority" => $task->getPriority()
        ]);

        if($result && $task->getId() === null){
            $task->setId((int)$this->db->lastInsertId());
        }

        return $result;
    }
   
    
}