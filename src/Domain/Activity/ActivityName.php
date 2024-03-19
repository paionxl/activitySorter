<?php

namespace App\Domain\Activity;

class ActivityName
{
    private string $name;

    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new \Exception('Activity name cannot be empty');
        }
        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->name;
    }
}
