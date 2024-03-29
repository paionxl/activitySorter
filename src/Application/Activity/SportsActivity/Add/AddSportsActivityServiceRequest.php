<?php

namespace App\Application\Activity\SportsActivity\Add;

use App\Application\Activity\Add\AddActivityServiceRequest;

class AddSportsActivityServiceRequest extends AddActivityServiceRequest
{
    private string $sportsType;

    public function __construct(string $type, string $name, string $description, string $sportsType)
    {
        $this->sportsType = $sportsType;
        parent::__construct($type, $name, $description);
    }

    public function getSportsType(): string
    {
        return $this->sportsType;
    }
}
