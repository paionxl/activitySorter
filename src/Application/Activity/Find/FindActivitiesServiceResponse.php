<?php

namespace App\Application\Activity\Find;

class FindActivitiesServiceResponse
{
    private array $activities;

    public function getActivities(): array
    {
        return $this->activities;
    }

    public function setActivities(array $activities): void
    {
        $this->activities = $activities;
    }
}
