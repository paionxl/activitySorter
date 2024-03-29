<?php

namespace App\Domain\Activity\SportsActivity;

use App\Exception\ActivitySorterException;

class SportsActivityType
{
    private string $type;

    public function __construct(string $type)
    {
        if (empty($type)) {
            throw new ActivitySorterException('Sports activity type cannot be empty');
        }
        $this->type = $type;
    }

    public function getValue(): string
    {
        return $this->type;
    }
}
