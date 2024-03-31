<?php

namespace App\Application\Activity\Adapter;

use App\Domain\Activity\Activity;

abstract class ActivityAdapter
{
    public function adapt(Activity $activity): array
    {
        return \array_merge(
            [
                'id' => $activity->getId()->getValue(),
                'name' => $activity->getActivityName()->getValue(),
                'description' => $activity->getActivityDescription()->getValue(),
                'type' => $activity->getActivityType()->getValue()
            ],
            $this->adaptSpecificFields($activity)
        );
    }

    abstract protected function adaptSpecificFields(Activity $activity): array;
}
