<?php

namespace App\Domain\Activity\ActivityRepository;

abstract class ActivityRepositoryCriteria
{
    private string $name;

    private string $description;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function hasName(): bool
    {
        return isset($this->name);
    }

    public function hasDescription(): bool
    {
        return isset($this->description);
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
