<?php

namespace App\Domain\Activity\ActivityRepository;

use App\Domain\Activity\Activity;
use App\Domain\Activity\ActivityCollection;
use App\Domain\Activity\ActivityId;

interface ActivityRepositoryInterface
{
    public function add(Activity $activity): ActivityId;

    public function findByCriteria(ActivityRepositoryCriteria $criteria): ActivityCollection;
}
