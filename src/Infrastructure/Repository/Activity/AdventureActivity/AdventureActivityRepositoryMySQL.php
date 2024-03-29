<?php

namespace App\Infrastructure\Repository\Activity\AdventureActivity;

use App\Domain\Activity\Activity;
use App\Domain\Activity\ActivityId;
use App\Domain\Activity\AdventureActivity\AdventureActivity;
use App\Infrastructure\Repository\Activity\ActivityRepositoryMySQL;

class AdventureActivityRepositoryMySQL extends ActivityRepositoryMySQL
{
    public function add(Activity $activity): ActivityId
    {
        try {
            $this->connection->beginTransaction();
            
            /** @var AdventureActivity $activity */
            $activityId = parent::add($activity);

            $query = 'INSERT INTO adventure_activity (activity_id, equipment_name) VALUES (:id, :equipment_name)';
            foreach ($activity->getAdventureActivityEquipmentCollection()->getEquipment() as $equipment) {
                $this->connection->executeQuery(
                    $query,
                    [
                        'id' => $activityId->getValue(),
                        'equipment_name' => $equipment->getValue()
                    ]
                );
            }

        } catch (\Exception $e) {
            $this->connection->rollBack();
            throw $e;
        }

        $this->connection->commit();

        return $activityId;
    }
}
