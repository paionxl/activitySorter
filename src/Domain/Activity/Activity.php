<?php

namespace App\Domain\Activity;

class Activity
{
    private ActivityName $activityName;

    private ActivityDescription $activityDescription;

    private ActivityType $activityType;

    public function __construct(
        ActivityName $activityName,
        ActivityDescription $activityDescription,
        ActivityType $activityType
    ) {
        $this->activityName = $activityName;
        $this->activityDescription = $activityDescription;
        $this->activityType = $activityType;
    }
}
