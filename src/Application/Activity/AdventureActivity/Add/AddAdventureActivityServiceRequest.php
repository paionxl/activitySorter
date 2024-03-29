<?php

namespace App\Application\Activity\AdventureActivity\Add;

use App\Application\Activity\Add\AddActivityServiceRequest;

class AddAdventureActivityServiceRequest extends AddActivityServiceRequest
{
    private array $equipments;

    public function __construct(string $type, string $name, string $description, array $equipments)
    {
        $this->equipments = $equipments;
        parent::__construct($type, $name, $description);
    }

    public function getEquipments(): array
    {
        return $this->equipments;
    }
}
