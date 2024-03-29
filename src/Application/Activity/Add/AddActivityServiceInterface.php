<?php

namespace App\Application\Activity\Add;

interface AddActivityServiceInterface
{
    public function add(AddActivityServiceRequest $addActivityServiceRequest): int;
}
