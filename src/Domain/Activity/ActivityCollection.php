<?php

namespace App\Domain\Activity;

class ActivityCollection
{
    /** @var Activity[] */
    private array $activities;

    /** @param Activity[] $activities */
    public function __construct(array $activities = [])
    {
        $this->activities = [];

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
