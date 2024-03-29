<?php

namespace App\Domain\Activity;

abstract class Activity
{
    private ActivityName $activityName;

    private ActivityDescription $activityDescription;

    private ActivityType $activityType;

    private ActivityId $activityId;

    public function __construct(
        ActivityName $activityName,
        ActivityDescription $activityDescription,
        ActivityType $activityType
    ) {
        $this->activityName = $activityName;
        $this->activityDescription = $activityDescription;
        $this->activityType = $activityType;
    }

    public function setId(ActivityId $activityId): void
    {
        $this->activityId = $activityId;
    }

    public function getActivityName(): ActivityName
    {
        return $this->activityName;
    }

    public function getActivityDescription(): ActivityDescription
    {
        return $this->activityDescription;
    }

    public function getActivityType(): ActivityType
    {
        return $this->activityType;
    }
}
