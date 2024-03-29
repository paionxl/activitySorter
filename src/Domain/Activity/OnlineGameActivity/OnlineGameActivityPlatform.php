<?php

namespace App\Domain\Activity\OnlineGameActivity;

use App\Exception\ActivitySorterException;

class OnlineGameActivityPlatform
{
    private string $name;

    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new ActivitySorterException('Online game activity platform cannot be empty');
        }
        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->name;
    }
}
