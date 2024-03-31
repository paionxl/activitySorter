<?php

namespace App\Application\Activity\Adapter;

use App\Domain\Activity\ActivityCollection;

class ActivityCollectionAdapter
{
    /** @var ActivityAdapter[] */
    private array $activityAdapters;

    public function __construct(array $activityAdapters)
    {
        $this->activityAdapters = $activityAdapters;
    }

    public function adapt(ActivityCollection $activityCollection): array
    {
        $activities = [];
        foreach ($activityCollection->getActivities() as $activity) {
            $activities[] = $this->activityAdapters[$activity->getActivityType()->getValue()]->adapt($activity);
        }
        return $activities;
    }
}
