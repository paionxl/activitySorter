<?php

namespace App\Domain\Activity\AdventureActivity\Repository;

use App\Domain\Activity\ActivityRepository\ActivityRepositoryCriteria;
use App\Domain\Activity\SportsActivity\SportsActivityType;

class SportsActivityRepositoryCriteria extends ActivityRepositoryCriteria
{
    private SportsActivityType $sportsActivityType;

    public function getSportsActivityType(): SportsActivityType
    {
        return $this->sportsActivityType;
    }

    public function setSportsActivityType(SportsActivityType $sportsActivityType): void
    {
        $this->sportsActivityType = $sportsActivityType;
    }

    public function hasSportsActivityType(): bool
    {
        return isset($this->sportsActivityType);
    }
}
