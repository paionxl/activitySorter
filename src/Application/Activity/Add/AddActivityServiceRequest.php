<?php

namespace App\Application\Activity\Add;

abstract class AddActivityServiceRequest
{
    private string $type;

    private string $name;
    
    private string $description;

    public function __construct(string $type, string $name, string $description)
    {
        $this->type = $type;
        $this->name = $name;
        $this->description = $description;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
