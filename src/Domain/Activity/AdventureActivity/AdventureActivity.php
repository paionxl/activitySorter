<?php

namespace App\Domain\Activity\AdventureActivity;

use App\Domain\Activity\Activity;
use App\Domain\Activity\ActivityName;
use App\Domain\Activity\ActivityType;
use App\Domain\Activity\ActivityDescription;
use App\Domain\Activity\AdventureActivity\AdventureActivityEquipment\AdventureActivityEquipmentCollection;

class AdventureActivity extends Activity
{
    private AdventureActivityEquipmentCollection $adventureActivityEquipmentCollection;

    public function __construct(
        ActivityName $activityName,
        ActivityDescription $activityDescription,
        ActivityType $activityType,
        AdventureActivityEquipmentCollection $adventureActivityEquipmentCollection
    ) {
        $this->adventureActivityEquipmentCollection = $adventureActivityEquipmentCollection;
        parent::__construct($activityName, $activityDescription, $activityType);
    }
}
