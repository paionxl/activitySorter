<?php

namespace App\Application\Activity\OnlineGameActivity\Add;

use App\Domain\Activity\Activity;
use App\Domain\Activity\ActivityType;
use App\Application\Activity\Add\AddActivityService;
use App\Application\Activity\Add\AddActivityServiceRequest;
use App\Domain\Activity\ActivityDescription;
use App\Domain\Activity\ActivityName;
use App\Domain\Activity\ActivityRepository\ActivityRepositoryInterface;
use App\Domain\Activity\OnlineGameActivity\OnlineGameActivity;
use App\Domain\Activity\OnlineGameActivity\OnlineGameActivityPlatform;

class AddOnlineGameActivityService extends AddActivityService
{
    public function __construct(
        ActivityRepositoryInterface $adventureActivityRepository
    ) {
        parent::__construct(
            $adventureActivityRepository,
            ActivityType::instance(ActivityType::ONLINE_GAME_ACTIVITY_TYPE)
        );
    }

    protected function buildActivity(AddActivityServiceRequest $addActivityServiceRequest): Activity
    {
        /** @var AddOnlineGameActivityServiceRequest $addActivityServiceRequest */

        return new OnlineGameActivity(
            new ActivityName($addActivityServiceRequest->getName()),
            new ActivityDescription($addActivityServiceRequest->getDescription()),
            new OnlineGameActivityPlatform($addActivityServiceRequest->getPlatform())
        );
    }
}
