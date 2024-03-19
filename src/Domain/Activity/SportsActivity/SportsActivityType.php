<?php

namespace App\Domain\Activity\SportsActivity;

class SportsActivityType
{
    private string $type;

    public function __construct(string $type)
    {
        if (empty($type)) {
            throw new \Exception('Sports activity type cannot be empty');
        }
        $this->type = $type;
    }

    public function getValue(): string
    {
        return $this->type;
    }
}
