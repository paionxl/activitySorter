<?php

namespace App\Application\Activity\Add;

use App\Domain\Activity\Activity;
use App\Exception\ActivitySorterException;
use App\Domain\Activity\ActivityRepository\ActivityRepositoryInterface;
use App\Domain\Activity\ActivityType;

abstract class AddActivityService implements AddActivityServiceInterface
{
    private ActivityRepositoryInterface $activityRepository;

    private ActivityType $serviceType;

    public function __construct(
        ActivityRepositoryInterface $activityRepository,
        ActivityType $serviceType
    ) {
        $this->activityRepository = $activityRepository;
        $this->serviceType = $serviceType;
    }

    public function add(AddActivityServiceRequest $addActivityServiceRequest): int
    {
        if (!ActivityType::instance($addActivityServiceRequest->getType())->equals($this->serviceType)) {
            throw new ActivitySorterException(
                'Type not valid. Expected ' . $this->serviceType->getValue() .
                ' and got ' . $addActivityServiceRequest->getType()
            );
        }
        $activity = $this->buildActivity($addActivityServiceRequest);
        return $this->activityRepository->add($activity)->getValue();
    }

    abstract protected function buildActivity(AddActivityServiceRequest $addActivityServiceRequest): Activity;
}
