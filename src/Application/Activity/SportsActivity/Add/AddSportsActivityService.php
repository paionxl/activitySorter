<?php

namespace App\Application\Activity\SportsActivity\Add;

use App\Domain\Activity\Activity;
use App\Domain\Activity\ActivityName;
use App\Domain\Activity\ActivityType;
use App\Domain\Activity\ActivityDescription;
use App\Application\Activity\Add\AddActivityService;
use App\Domain\Activity\AdventureActivity\SportsActivity;
use App\Application\Activity\Add\AddActivityServiceRequest;
use App\Domain\Activity\ActivityRepository\ActivityRepositoryInterface;
use App\Domain\Activity\SportsActivity\SportsActivityType;

class AddSportsActivityService extends AddActivityService
{
    public function __construct(
        ActivityRepositoryInterface $adventureActivityRepository
    ) {
        parent::__construct(
            $adventureActivityRepository,
            ActivityType::instance(ActivityType::SPORTS_ACTIVITY_TYPE)
        );
    }

    protected function buildActivity(AddActivityServiceRequest $addActivityServiceRequest): Activity
    {
        /** @var AddSportsActivityServiceRequest $addActivityServiceRequest */

        return new SportsActivity(
            new ActivityName($addActivityServiceRequest->getName()),
            new ActivityDescription($addActivityServiceRequest->getDescription()),
            new SportsActivityType($addActivityServiceRequest->getSportsType())
        );
    }
}
