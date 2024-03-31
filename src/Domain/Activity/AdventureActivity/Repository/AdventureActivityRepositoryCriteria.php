<?php

namespace App\Domain\Activity\AdventureActivity\Repository;

use App\Domain\Activity\ActivityRepository\ActivityRepositoryCriteria;
use App\Domain\Activity\AdventureActivity\AdventureActivityEquipment\AdventureActivityEquipment;

class AdventureActivityRepositoryCriteria extends ActivityRepositoryCriteria
{
    private AdventureActivityEquipment $equipment;

    public function getEquipment(): AdventureActivityEquipment
    {
        return $this->equipment;
    }

    public function setEquipment(AdventureActivityEquipment $equipment): void
    {
        $this->equipment = $equipment;
    }

    public function hasEquipment(): bool
    {
        return isset($this->equipment);
    }
}
