<?php

namespace App\Repository;

use App\Models\Task;
use App\Models\BugTask;
use App\Models\FeatureTask;
use PDO;
use PDOException;
use PDOStatement;

class TaskRepository extends BaseRepository
{
   
    public function save(Task $task) :bool
    {
        if($task->getId() === null){
    
                $sql = "INSERT INTO tasks (creator_id, assigned_to, project_id, title, status, type, priority) VALUES (:creator_id, :assigned_to, :project_id, :title, :status, :type, :priority)";

                $params = [
                    ":creator_id" => $task->getCreatorId(),
                    ":assigned_to" => $task->getAssignedTo(),
                    ":project_id" => $task->getProjectId(),
                    ":title" => $task->getTitle(),
                    ":status" => $task->getStatus(),
                    ":type" => $task->getType(),
                    ":priority" => $task->getPriority()
                ];

                $stmt = $this->query($sql, $params);
                
                if($stmt instanceof PDOStatement){
                    $task->setId((int)$this->db->lastInsertId());
                    return true;
                }
               
                return false;         
            
        }else{
      
                $sql = "UPDATE tasks SET assigned_to = :assigned_to,  title = :title, status = :status, priority = :priority, finished_at = :finished_at, assigned_at = :assigned_at  WHERE id = :id";

                $params = [
                    ":id" => $task->getId(),
                    ":title" => $task->getTitle(),
                    ":status" => $task->getStatus(),
                    ":priority" => $task->getPriority(),
                    ":finished_at" => $task->getFinishedAt(),
                    ":assigned_to" => $task->getAssignedTo(), 
                    ":assigned_at" => $task->getAssignedAt()
                ];

                return (bool)$this->query($sql, $params);
        }     
    }

    public function findAll() :array
    {
   
            $sql = "SELECT * FROM tasks";
            $stmt = $this->query($sql);

            $tasks = [];

            if($stmt instanceof PDOStatement){
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                    $task = $this->mapToEntity($row);
                    
                    if($task){
                        $tasks[] = $task;
                    }
                }
            }
            return $tasks;
        
    }

    public function find(int $id) :?Task
    {
        
            $sql = "SELECT * FROM tasks WHERE id = :id";

            $stmt = $this->query($sql, [":id" => $id]);

            if($stmt instanceof PDOStatement && $row = $stmt->fetch(PDO::FETCH_ASSOC)){
                   return $this->mapToEntity($row);
            }
    
            return null;
    }

    private function mapToEntity(array $row) :?Task
    {
        $task = null;

        $assignedTo = ($row["assigned_to"] !== null) ? (int)$row["assigned_to"] : null;

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
        $sql = "DELETE FROM tasks WHERE id = :id";

        return (bool)$stmt = $this->query($sql, [":id" => $id]);
    }
}