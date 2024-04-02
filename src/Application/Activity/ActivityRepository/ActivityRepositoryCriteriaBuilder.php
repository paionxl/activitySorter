<?php

namespace App\Application\Activity\ActivityRepository;

use App\Domain\Activity\ActivityType;
use App\Exception\ActivitySorterException;
use App\Domain\Activity\SportsActivity\SportsActivityType;
use App\Domain\Activity\ActivityRepository\ActivityRepositoryCriteria;
use App\Domain\Activity\OnlineGameActivity\OnlineGameActivityPlatform;
use App\Domain\Activity\SportsActivity\Repository\SportsActivityRepositoryCriteria;
use App\Domain\Activity\AdventureActivity\Repository\AdventureActivityRepositoryCriteria;
use App\Domain\Activity\OnlineGameActivity\Repository\OnlineGameActivityRepositoryCriteria;
use App\Domain\Activity\AdventureActivity\AdventureActivityEquipment\AdventureActivityEquipment;

class ActivityRepositoryCriteriaBuilder
{
    public function build(
        ActivityRepositoryCriteriaBuilderRequest $activityRepositoryCriteriaBuilderRequest
    ): ActivityRepositoryCriteria {
        switch ($activityRepositoryCriteriaBuilderRequest->getType()) {
            case ActivityType::ADVENTURE_ACTIVITY_TYPE:
                $criteria = new AdventureActivityRepositoryCriteria();
                if ($activityRepositoryCriteriaBuilderRequest->hasEquipment()) {
                    $criteria->setEquipment(
                        new AdventureActivityEquipment($activityRepositoryCriteriaBuilderRequest->getEquipment())
                    );
                }

                break;
            case ActivityType::ONLINE_GAME_ACTIVITY_TYPE:
                $criteria = new OnlineGameActivityRepositoryCriteria();
                if ($activityRepositoryCriteriaBuilderRequest->hasPlatform()) {
                    $criteria->setPlatform(
                        new OnlineGameActivityPlatform($activityRepositoryCriteriaBuilderRequest->getPlatform())
                    );
                }

                break;
            case ActivityType::SPORTS_ACTIVITY_TYPE:
                $criteria = new SportsActivityRepositoryCriteria();
                if ($activityRepositoryCriteriaBuilderRequest->hasSportsType()) {
                    $criteria->setSportsActivityType(
                        new SportsActivityType($activityRepositoryCriteriaBuilderRequest->getSportsType())
                    );
                }

                break;
            default:
                throw new ActivitySorterException(
                    'Type to find not supported: ' . $activityRepositoryCriteriaBuilderRequest->getType()
                );
        }

        if ($activityRepositoryCriteriaBuilderRequest->hasName()) {
            $criteria->setName($activityRepositoryCriteriaBuilderRequest->getName());
        }

        if ($activityRepositoryCriteriaBuilderRequest->hasDescription()) {
            $criteria->setDescription($activityRepositoryCriteriaBuilderRequest->getDescription());
        }

        return $criteria;
    }
}
