<?php

namespace App\Models;

class BugTask extends Task
{
    
    
    public function __construct(int $creatorId, int $projectId, string $title, int $priority = 1, ?int $id = null, ?int $assignedTo = null, string $status = "todo")
    {
       parent::__construct($creatorId, $projectId, $title, "bug", $priority, $id, $assignedTo, $status);
    }

    public function getCalculatedPriority() :int
    {
        return $this->priority * 2;
    }

}