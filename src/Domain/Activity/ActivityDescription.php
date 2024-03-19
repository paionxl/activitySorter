<?php

namespace App\Domain\Activity;

class ActivityDescription
{
    private string $description;

    public function __construct(string $description)
    {
        if (empty($description)) {
            throw new \Exception('Activity description cannot be empty');
        }
        $this->description = $description;
    }

    public function getValue(): string
    {
        return $this->description;
    }
}
