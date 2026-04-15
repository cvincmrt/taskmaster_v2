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
    protected string $colorTask;


    public function __construct(int $creatorId, ?int $assignedTo, int $projectId, string $title, string $status = "todo", string $type, int $priority = 1, ?int $id = null)
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



    //setters

    public function setId(int $id) :void
    {
        $this->id = $id;
    }

    public function setColorTask(string $color) :void
    {
        $this->colorTask = $color;
    }
}