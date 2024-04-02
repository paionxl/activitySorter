<?php

namespace App\Domain\Activity\SportsActivity;

use App\Domain\Activity\Activity;
use App\Domain\Activity\ActivityName;
use App\Domain\Activity\ActivityType;
use App\Domain\Activity\ActivityDescription;

class SportsActivity extends Activity
{
    private SportsActivityType $sportsActivityType;

    public function __construct(
        ActivityName $activityName,
        ActivityDescription $activityDescription,
        SportsActivityType $sportsActivityType
    ) {
        $this->sportsActivityType = $sportsActivityType;
        parent::__construct(
            $activityName,
            $activityDescription,
            ActivityType::instance(ActivityType::SPORTS_ACTIVITY_TYPE)
        );
    }

    public function getSportsActivityType(): SportsActivityType
    {
        return $this->sportsActivityType;
    }
}
