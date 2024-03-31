<?php

namespace App\Application\Activity\AdventureActivity\Add;

use App\Application\Activity\Add\AddActivityServiceRequest;
use App\Domain\Activity\ActivityType;

class AddAdventureActivityServiceRequest extends AddActivityServiceRequest
{
    private array $equipments;

    public function __construct(string $name, string $description, array $equipments)
    {
        $this->equipments = $equipments;
        parent::__construct(ActivityType::ADVENTURE_ACTIVITY_TYPE, $name, $description);
    }

    public function getEquipments(): array
    {
        return $this->equipments;
    }
}
