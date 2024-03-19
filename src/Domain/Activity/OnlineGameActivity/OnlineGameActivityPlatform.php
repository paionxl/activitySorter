<?php

namespace App\Domain\Activity\OnlineGameActivity;

class OnlineGameActivityPlatform
{
    private string $name;

    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new \Exception('Online game activity platform cannot be empty');
        }
        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->name;
    }
}
