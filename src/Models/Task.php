<?php

namespace App\Models;

abstract class Task
{
    protected ?int $id = null;
    protected int $creatorId;
    protected ?int $assignedTo = null;
    protected int $projectId;
    protected string $title;
    protected string $status; //todo, doing, done default=todo
    protected string $type; //bug, feature
    protected int $priority; //default=1

    protected ?string $createdAt = null;
    protected ?string $assignedAt = null;
    protected ?string $finishedAt = null;
    protected string $colorTask = "bg-black";


    public function __construct(int $creatorId, int $projectId, string $title, string $type, int $priority = 1, ?int $id = null, ?int $assignedTo = null, string $status = "todo")
    {
        $this->id = $id;
        $this->creatorId = $creatorId;
        $this->assignedTo = $assignedTo;
        $this->projectId = $projectId;
        $this->title = $title;
        $this->status = $status;
        $this->type = $type;
        $this->priority = $priority;
    }

    abstract public function getCalculatedPriority();
    
    // getters

    public function getId() :?int
    {
        return $this->id;
    }

    public function getCreatorId() :int
    {
        return $this->creatorId;
    }

    public function getAssignedTo() :?int
    {
        return $this->assignedTo;
    }

    public function getProjectId() :int
    {
        return $this->projectId;
    }

    public function getTitle() :string
    {
        return $this->title;
    }

     public function getStatus() :string
    {
        return $this->status;
    }

     public function getType() :string
    {
        return $this->type;
    }

     public function getPriority() :int
    {
        return $this->priority;
    }

    public function getColorTask() :string
    {
        return (basename(get_class($this)) === "BugTask") ? "bg-danger" : "bg-primary";
    }

    public function getCreatedAt() :?string
    {
        return $this->createdAt;
    }

    public function getAssignedAt() :?string
    {
        return $this->assignedAt;
    }

    public function getFinishedAt() :?string
    {
        return $this->finishedAt;
    }



    //setters *********************************

    public function setId(int $id) :void
    {
        $this->id = $id;
    }

    public function setCreatedAt(string $date) :void
    {
        $this->createdAt = $date;
    }

    public function setAssignedAt(?string $date) :void
    {
        $this->assignedAt = $date;
    }

    public function setFinishedAt(?string $date) :void
    {
        $this->finishedAt = $date;
    }

}