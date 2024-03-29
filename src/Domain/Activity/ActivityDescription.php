<?php

namespace App\Domain\Activity;

use App\Exception\ActivitySorterException;

class ActivityDescription
{
    private string $description;

    public function __construct(string $description)
    {
        if (empty($description)) {
            throw new ActivitySorterException('Activity description cannot be empty');
        }
        $this->description = $description;
    }

    public function getValue(): string
    {
        return $this->description;
    }
}
