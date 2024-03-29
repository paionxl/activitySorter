<?php

namespace App\Domain\Activity\OnlineGameActivity;

use App\Domain\Activity\Activity;
use App\Domain\Activity\ActivityName;
use App\Domain\Activity\ActivityType;
use App\Domain\Activity\ActivityDescription;

class OnlineGameActivity extends Activity
{
    private OnlineGameActivityPlatform $onlineGameActivityPlatform;

    public function __construct(
        ActivityName $activityName,
        ActivityDescription $activityDescription,
        OnlineGameActivityPlatform $onlineGameActivityPlatform
    ) {
        $this->onlineGameActivityPlatform = $onlineGameActivityPlatform;
        parent::__construct(
            $activityName,
            $activityDescription,
            ActivityType::instance(ActivityType::ONLINE_GAME_ACTIVITY_TYPE)
        );
    }

    public function getPlatform(): OnlineGameActivityPlatform
    {
        return $this->onlineGameActivityPlatform;
    }
}
