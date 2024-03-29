<?php

namespace App\Domain\Activity\AdventureActivity\AdventureActivityEquipment;

use App\Exception\ActivitySorterException;

class AdventureActivityEquipment
{
    private string $name;

    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new ActivitySorterException('Adventure activity equipment name cannot be empty');
        }
        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->name;
    }
}
