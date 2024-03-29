<?php

namespace App\Application\Activity\OnlineGameActivity\Add;

use App\Application\Activity\Add\AddActivityServiceRequest;

class AddOnlineGameActivityServiceRequest extends AddActivityServiceRequest
{
    private string $platform;

    public function __construct(string $type, string $name, string $description, string $platform)
    {
        $this->platform = $platform;
        parent::__construct($type, $name, $description);
    }

    public function getPlatform(): string
    {
        return $this->platform;
    }
}
