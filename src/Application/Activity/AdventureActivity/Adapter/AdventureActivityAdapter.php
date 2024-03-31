<?php

namespace App\Application\Activity\AdventureActivity\Adapter;

use App\Domain\Activity\Activity;
use App\Application\Activity\Adapter\ActivityAdapter;
use App\Domain\Activity\AdventureActivity\AdventureActivity;

class AdventureActivityAdapter extends ActivityAdapter
{
    protected function adaptSpecificFields(Activity $activity): array
    {
        /** @var AdventureActivity $activity */
        $equipments = [];
        foreach ($activity->getAdventureActivityEquipmentCollection()->getEquipment() as $equipment) {
            $equipments[] = $equipment->getValue();
        }

        return [
            'equipments' => $equipments
        ];
    }
}
