<?php

namespace App\Application\Activity\AdventureActivity\Add;

use App\Domain\Activity\Activity;
use App\Application\Activity\Add\AddActivityService;
use App\Application\Activity\Add\AddActivityServiceRequest;
use App\Domain\Activity\ActivityDescription;
use App\Domain\Activity\ActivityName;
use App\Domain\Activity\ActivityRepository\ActivityRepositoryInterface;
use App\Domain\Activity\ActivityType;
use App\Domain\Activity\AdventureActivity\AdventureActivity;
use App\Domain\Activity\AdventureActivity\AdventureActivityEquipment\AdventureActivityEquipmentCollection;

class AddAdventureActivityService extends AddActivityService
{
    public function __construct(
        ActivityRepositoryInterface $adventureActivityRepository
    ) {
        parent::__construct(
            $adventureActivityRepository,
            ActivityType::instance(ActivityType::ADVENTURE_ACTIVITY_TYPE)
        );
    }

    protected function buildActivity(AddActivityServiceRequest $addActivityServiceRequest): Activity
    {
        /** @var AddAdventureActivityServiceRequest $addActivityServiceRequest */
        return new AdventureActivity(
            new ActivityName($addActivityServiceRequest->getName()),
            new ActivityDescription($addActivityServiceRequest->getDescription()),
            AdventureActivityEquipmentCollection::createFromArray($addActivityServiceRequest->getEquipments())
        );
    }
}
