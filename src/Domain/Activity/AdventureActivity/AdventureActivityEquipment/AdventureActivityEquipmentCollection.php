<?php

namespace App\Domain\Activity\AdventureActivity\AdventureActivityEquipment;

class AdventureActivityEquipmentCollection
{
    /** @var AdventureActivityEquipment[] */
    private array $equipments;

    public function __construct(array $equipments = [])
    {
        $this->equipments = [];
        /** @var AdventureActivityEquipment $equipment */
        foreach ($equipments as $equipment) {
            $this->addEquipment($equipment);
        }
    }

    public function addEquipment(AdventureActivityEquipment $equipment): void
    {
        $this->equipments[] = $equipment;
    }

    /**
     * @return AdventureActivityEquipment[]
     */
    public function getEquipment(): array
    {
        return $this->equipments;
    }

    public static function createFromArray(array $equipments): AdventureActivityEquipmentCollection
    {
        $equipmentsToAdd = [];
        foreach ($equipments as $equipment) {
            $equipmentsToAdd[] = new AdventureActivityEquipment($equipment);
        }
        return new self($equipmentsToAdd);
    }
}
