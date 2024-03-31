<?php

namespace App\Application\Activity\Find;

interface FindActivitiesServiceInterface
{
    public function find(FindActivitiesServiceRequest $findActivitiesServiceRequest): FindActivitiesServiceResponse;
}
