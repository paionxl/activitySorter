<?php

namespace App\Application\Activity\SportsActivity\Adapter;

use App\Domain\Activity\Activity;
use App\Application\Activity\Adapter\ActivityAdapter;
use App\Domain\Activity\AdventureActivity\SportsActivity;

class SportsActivityAdapter extends ActivityAdapter
{
    protected function adaptSpecificFields(Activity $activity): array
    {
        /** @var SportsActivity $activity */
        return [
            'sports_type' => $activity->getSportsActivityType()->getValue()
        ];
    }
}
