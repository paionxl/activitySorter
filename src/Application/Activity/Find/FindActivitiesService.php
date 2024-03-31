<?php

namespace App\Application\Activity\Find;

use App\Domain\Activity\ActivityType;
use App\Exception\ActivitySorterException;
use App\Domain\Activity\ActivityCollection;
use App\Domain\Activity\SportsActivity\SportsActivityType;
use App\Application\Activity\Adapter\ActivityCollectionAdapter;
use App\Domain\Activity\ActivityRepository\ActivityRepositoryCriteria;
use App\Domain\Activity\OnlineGameActivity\OnlineGameActivityPlatform;
use App\Domain\Activity\ActivityRepository\ActivityRepositoryInterface;
use App\Domain\Activity\AdventureActivity\Repository\SportsActivityRepositoryCriteria;
use App\Domain\Activity\AdventureActivity\Repository\AdventureActivityRepositoryCriteria;
use App\Domain\Activity\AdventureActivity\Repository\OnlineGameActivityRepositoryCriteria;
use App\Domain\Activity\AdventureActivity\AdventureActivityEquipment\AdventureActivityEquipment;

class FindActivitiesService implements FindActivitiesServiceInterface
{
    /** @var ActivityRepositoryInterface[] */
    private array $repositories;

    private ActivityCollectionAdapter $activityCollectionAdapter;

    public function __construct(array $repositories, ActivityCollectionAdapter $activityCollectionAdapter)
    {
        $this->repositories = $repositories;
        $this->activityCollectionAdapter = $activityCollectionAdapter;
    }

    public function find(FindActivitiesServiceRequest $findActivitiesServiceRequest): FindActivitiesServiceResponse
    {
        $activities = new ActivityCollection();

        $repositories = $this->repositories;
        if ($findActivitiesServiceRequest->hasType()) {
            if (!\array_key_exists($findActivitiesServiceRequest->getType(), $this->repositories)) {
                throw new ActivitySorterException(
                    'Type to find not supported: ' . $findActivitiesServiceRequest->getType()
                );
            }
            $repositories = [
                $findActivitiesServiceRequest->getType() =>
                    $this->repositories[$findActivitiesServiceRequest->getType()]
            ];
        }

        foreach ($repositories as $type => $repository) {
            $activities = $activities->addCollections(
                $repository->findByCriteria(
                    $this->buildCriteria($type, $findActivitiesServiceRequest)
                )
            );
        }
        $response = new FindActivitiesServiceResponse();
        $response->setActivities($this->activityCollectionAdapter->adapt($activities));
        return $response;
    }

    private function buildCriteria(
        string $type,
        FindActivitiesServiceRequest $findActivitiesServiceRequest
    ): ActivityRepositoryCriteria {
        switch ($type) {
            case ActivityType::ADVENTURE_ACTIVITY_TYPE:
                $criteria = new AdventureActivityRepositoryCriteria();
                if ($findActivitiesServiceRequest->hasEquipment()) {
                    $criteria->setEquipment(
                        new AdventureActivityEquipment($findActivitiesServiceRequest->getEquipment())
                    );
                }

                break;
            case ActivityType::ONLINE_GAME_ACTIVITY_TYPE:
                $criteria = new OnlineGameActivityRepositoryCriteria();
                if ($findActivitiesServiceRequest->hasPlatform()) {
                    $criteria->setPlatform(
                        new OnlineGameActivityPlatform($findActivitiesServiceRequest->getPlatform())
                    );
                }

                break;
            case ActivityType::SPORTS_ACTIVITY_TYPE:
                $criteria = new SportsActivityRepositoryCriteria();
                if ($findActivitiesServiceRequest->hasSportsType()) {
                    $criteria->setSportsActivityType(
                        new SportsActivityType($findActivitiesServiceRequest->getSportsType())
                    );
                }

                break;
            default:
                throw new ActivitySorterException(
                    'Type to find not supported: ' . $findActivitiesServiceRequest->getType()
                );
        }

        if ($findActivitiesServiceRequest->hasName()) {
            $criteria->setName($findActivitiesServiceRequest->getName());
        }

        if ($findActivitiesServiceRequest->hasDescription()) {
            $criteria->setDescription($findActivitiesServiceRequest->getDescription());
        }

        return $criteria;
    }
}
