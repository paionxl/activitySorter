<?php

namespace App\Application\Activity\SportsActivity\Add;

use App\Application\Activity\Add\AddActivityServiceRequest;
use App\Domain\Activity\ActivityType;

class AddSportsActivityServiceRequest extends AddActivityServiceRequest
{
    private string $sportsType;

    public function __construct(string $name, string $description, string $sportsType)
    {
        $this->sportsType = $sportsType;
        parent::__construct(ActivityType::SPORTS_ACTIVITY_TYPE, $name, $description);
    }

    public function getSportsType(): string
    {
        return $this->sportsType;
    }
}
