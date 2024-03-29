<?php

namespace App\Domain\Activity;

use App\Exception\ActivitySorterException;

class ActivityId
{
    private int $id;

    public function __construct(int $id)
    {
        if (empty($id)) {
            throw new ActivitySorterException('Activity id cannot be empty');
        }
        $this->id = $id;
    }

    public function getValue(): int
    {
        return $this->id;
    }
}
