<?php

namespace App\Application\Activity\OnlineGameActivity\Adapter;

use App\Domain\Activity\Activity;
use App\Application\Activity\Adapter\ActivityAdapter;
use App\Domain\Activity\OnlineGameActivity\OnlineGameActivity;

class OnlineGameActivityAdapter extends ActivityAdapter
{
    protected function adaptSpecificFields(Activity $activity): array
    {
        /** @var OnlineGameActivity $activity */
        return [
            'platform' => $activity->getPlatform()->getValue()
        ];
    }
}
