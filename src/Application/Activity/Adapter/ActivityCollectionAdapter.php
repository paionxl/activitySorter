<?php

namespace App\Application\Activity\Adapter;

use App\Domain\Activity\ActivityCollection;
use App\Exception\ActivitySorterException;

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
            if (!\array_key_exists($activity->getActivityType()->getValue(), $this->activityAdapters)) {
                throw new ActivitySorterException(
                    'Adapter for activity type ' . $activity->getActivityType()->getValue() . ' not implemented.'
                );
            }
            $activities[] = $this->activityAdapters[$activity->getActivityType()->getValue()]->adapt($activity);
        }
        return $activities;
    }
}
