<?php

namespace App\Domain\Activity\AdventureActivity\AdventureActivityEquipment;

class AdventureActivityEquipmentCollection
{
    /** @var AdventureActivityEquipment[] */
    private array $equipments;

    public function __construct(array $equipments = [])
    {
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
}
