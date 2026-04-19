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
        if($task->getId() === null){
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
            
        }else{
            try{
                $sql = "UPDATE tasks SET assigned_to = :assigned_to,  title = :title, status = :status, priority = :priority, finished_at = :finished_at, assigned_at = :assigned_at  WHERE id = :id";

                $stmt = $this->db->prepare($sql);

                return $stmt->execute([
                    ":id" => $task->getId(),
                    ":title" => $task->getTitle(),
                    ":status" => $task->getStatus(),
                    ":priority" => $task->getPriority(),
                    ":finished_at" => $task->getFinishedAt(),
                    ":assigned_to" => $task->getAssignedTo(), 
                    ":assigned_at" => $task->getAssignedAt()
                ]);
            }
            catch(PDOException $e){
                return false;
            }            
        }     
    }

    public function findAll() :array
    {
        try{
            $tasks = [];    
            
            $sql = "SELECT * FROM tasks";
            $stmt = $this->db->query($sql);

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                $task = $this->mapToEntity($row);
                
                if($task){
                    $tasks[] = $task;
                }
            }
            return $tasks;
        }
        catch(PDOException $e){
        return [];
        }
    }

    public function find(int $id) :?Task
    {
        try{
            $sql = "SELECT * FROM tasks WHERE id = :id";
            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ":id" => $id
            ]);

            if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                   return $this->mapToEntity($row);
            }
        }
        catch(PDOException $e){
            return null;
        }   
        
        return null;
    }

    private function mapToEntity(array $row) :?Task
    {
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
        }

        return $task;
    }

    public function delete(int $id) :bool
    {
        try{
            $sql = "DELETE FROM tasks WHERE id = :id";

            $stmt = $this->db->prepare($sql);

            return $stmt->execute([
                ":id" => $id
            ]);
        }
        catch(PDOException $e){
            return false;

        }
    }
}