<?php

namespace App\Domain\Activity\AdventureActivity\AdventureActivityEquipment;

class AdventureActivityEquipment
{
    private string $name;

    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new \Exception('Adventure activity equipment name cannot be empty');
        }
        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->name;
    }
}
