<?php

namespace App\Models;

class Project
{
    private ?int $id = null;
    private int $ownerId;
    private string $title;
    private string $description;

    public function __construct(int $ownerId, string $title, string $description, ?int $id = null)
    {
        $this->id = $id;
        $this->ownerId = $ownerId;
        $this->title = $title;
        $this->description = $description;
    }

    //getters

    public function getId() :?int
    {
        return $this->id;
    }

    public function getOwnerId() :int
    {
        return $this->ownerId;
    }

    public function getTitle() :string
    {
        return $this->title;
    }

    public function getDescription() :string
    {
        return $this->description;
    }

    //setters

    public function setId(int $id) :void
    {
        $this->id = $id;
    }

    public function setOwner(int $ownerId) :void
    {
        $this->ownerId = $ownerId;
    }
}