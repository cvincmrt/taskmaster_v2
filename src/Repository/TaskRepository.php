<?php

namespace App\Repository;

use App\Models\Task;
use App\Models\BugTask;
use App\Models\FeatureTask;
use PDO;
use PDOException;

class TaskRepository
{
    private PDO $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function save(Task $task) :bool
    {
        try{
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
        catch(PDOException $e){
            return false;
        }
    }

    public function findAll() :array
    {
        try{
            $tasks = [];    
            
            $sql = "SELECT * FROM tasks";
            $stmt = $this->db->query($sql);

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                $task = null;

                $assignedTo = $row["assigned_to"] !== null ? (int)$row["assigned_to"] : null;

                switch($row["type"]){
                    case "bug":
                        $task = new BugTask((int)$row["creator_id"], (int)$row["project_id"], $row["title"], (int)$row["priority"], (int)$row["id"], $assignedTo, $row["status"]);
                        break; 
                    
                    case "feature":
                        $task = new FeatureTask((int)$row["creator_id"], (int)$row["project_id"], $row["title"], (int)$row["priority"], (int)$row["id"], $assignedTo, $row["status"]);
                        break;
                } 
                
                if($task){
                    $task->setCreatedAt($row["created_at"]);
                    $task->setAssignedAt($row["assigned_at"]);
                    $task->setFinishedAt($row["finished_at"]);

                    $tasks[] = $task;
                }
                
            }
            return $tasks;
        }
        catch(PDOException $e){
        return [];
        }
    }
   
    
}