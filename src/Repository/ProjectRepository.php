<?php

namespace App\Repository;

use PDO;
use App\Models\Project;

class ProjectRepository extends BaseRepository
{
    public function save(Project $project) :bool
    {
        $sql = "INSERT INTO projects (owner_id, title, description) VALUES (:owner_id, :title, :description)";

        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            ":owner_id" => $project->getOwnerId(),
            ":title" => $project->getTitle(),
            ":description" => $project->getDescription()
        ]);

        if($result && $project->getId() === null){
            $project->setId((int)$this->db->lastInsertId());
        }

        return $result;
         
    }

}