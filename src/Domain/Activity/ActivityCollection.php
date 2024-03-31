<?php

namespace App\Domain\Activity;

class ActivityCollection
{
    /** @var Activity[] */
    private array $activities;

    public function __construct(array $activities = [])
    {
        $this->activities = [];
        /** @var Activity $activity */
        foreach ($activities as $activity) {
            $this->addActivity($activity);
        }
    }

    public function addActivity(Activity $activity): void
    {
        $this->activities[] = $activity;
    }

    /**
     * @return Activity[]
     */
    public function getActivities(): array
    {
        return $this->activities;
    }

    public function addCollections(ActivityCollection $collection): ActivityCollection
    {
        foreach($collection->getActivities() as $activity) {
            $this->addActivity($activity);
        }

        return $this;
    }
}
