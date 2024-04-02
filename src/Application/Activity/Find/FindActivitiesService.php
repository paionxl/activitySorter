<?php

namespace App\Application\Activity\Find;

use App\Exception\ActivitySorterException;
use App\Domain\Activity\ActivityCollection;
use App\Application\Activity\Adapter\ActivityCollectionAdapter;
use App\Domain\Activity\ActivityRepository\ActivityRepositoryInterface;
use App\Application\Activity\ActivityRepository\ActivityRepositoryCriteriaBuilder;
use App\Application\Activity\ActivityRepository\ActivityRepositoryCriteriaBuilderRequest;

class FindActivitiesService implements FindActivitiesServiceInterface
{
    /** @var ActivityRepositoryInterface[] */
    private array $repositories;

    private ActivityCollectionAdapter $activityCollectionAdapter;

    private ActivityRepositoryCriteriaBuilder $activityRepositoryCriteriaBuilder;

    public function __construct(
        array $repositories,
        ActivityCollectionAdapter $activityCollectionAdapter,
        ActivityRepositoryCriteriaBuilder $activityRepositoryCriteriaBuilder
    ) {
        $this->repositories = $repositories;
        $this->activityCollectionAdapter = $activityCollectionAdapter;
        $this->activityRepositoryCriteriaBuilder = $activityRepositoryCriteriaBuilder;
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
                    $this->activityRepositoryCriteriaBuilder->build(
                        $this->createBuilderRequest($type, $findActivitiesServiceRequest)
                    )
                )
            );
        }
        $response = new FindActivitiesServiceResponse();
        $response->setActivities($this->activityCollectionAdapter->adapt($activities));
        return $response;
    }

    private function createBuilderRequest(
        string $type,
        FindActivitiesServiceRequest $findActivitiesServiceRequest
    ): ActivityRepositoryCriteriaBuilderRequest {

        $activityRepositoryCriteriaBuilderRequest = new ActivityRepositoryCriteriaBuilderRequest();

        if ($findActivitiesServiceRequest->hasEquipment()) {
            $activityRepositoryCriteriaBuilderRequest->setEquipment($findActivitiesServiceRequest->getEquipment());
        }
        if ($findActivitiesServiceRequest->hasPlatform()) {
            $activityRepositoryCriteriaBuilderRequest->setPlatform($findActivitiesServiceRequest->getPlatform());
        }
        if ($findActivitiesServiceRequest->hasSportsType()) {
            $activityRepositoryCriteriaBuilderRequest->setSportsType($findActivitiesServiceRequest->getSportsType());
        }
        if ($findActivitiesServiceRequest->hasName()) {
            $activityRepositoryCriteriaBuilderRequest->setName($findActivitiesServiceRequest->getName());
        }
        if ($findActivitiesServiceRequest->hasDescription()) {
            $activityRepositoryCriteriaBuilderRequest->setDescription($findActivitiesServiceRequest->getDescription());
        }

        $activityRepositoryCriteriaBuilderRequest->setType($type);
        return $activityRepositoryCriteriaBuilderRequest;
    }
}
