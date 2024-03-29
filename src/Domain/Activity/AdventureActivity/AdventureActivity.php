<?php

namespace App\Domain\Activity\AdventureActivity;

use App\Domain\Activity\Activity;
use App\Domain\Activity\ActivityName;
use App\Domain\Activity\ActivityType;
use App\Domain\Activity\ActivityDescription;
use App\Domain\Activity\AdventureActivity\AdventureActivityEquipment\AdventureActivityEquipmentCollection;
use App\Exception\ActivitySorterException;

class AdventureActivity extends Activity
{
    private AdventureActivityEquipmentCollection $adventureActivityEquipmentCollection;

    public function __construct(
        ActivityName $activityName,
        ActivityDescription $activityDescription,
        AdventureActivityEquipmentCollection $adventureActivityEquipmentCollection
    ) {
        $this->adventureActivityEquipmentCollection = $adventureActivityEquipmentCollection;
        parent::__construct(
            $activityName,
            $activityDescription,
            ActivityType::instance(ActivityType::ADVENTURE_ACTIVITY_TYPE)
        );
    }

    public function getAdventureActivityEquipmentCollection(): AdventureActivityEquipmentCollection
    {
        return $this->adventureActivityEquipmentCollection;
    }
}
