<?php

namespace App\Application\Activity\OnlineGameActivity\Add;

use App\Application\Activity\Add\AddActivityServiceRequest;
use App\Domain\Activity\ActivityType;

class AddOnlineGameActivityServiceRequest extends AddActivityServiceRequest
{
    private string $platform;

    public function __construct(string $name, string $description, string $platform)
    {
        $this->platform = $platform;
        parent::__construct(ActivityType::ONLINE_GAME_ACTIVITY_TYPE, $name, $description);
    }

    public function getPlatform(): string
    {
        return $this->platform;
    }
}
