<?php

namespace App\Domain\Activity;

use App\Exception\ActivitySorterException;

class ActivityName
{
    private string $name;

    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new ActivitySorterException('Activity name cannot be empty');
        }
        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->name;
    }
}
