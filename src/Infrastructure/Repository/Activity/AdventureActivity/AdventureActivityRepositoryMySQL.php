<?php

namespace App\Infrastructure\Repository\Activity\AdventureActivity;

use App\Domain\Activity\Activity;
use App\Domain\Activity\ActivityId;
use App\Domain\Activity\ActivityName;
use App\Domain\Activity\ActivityType;
use App\Domain\Activity\ActivityCollection;
use App\Domain\Activity\ActivityDescription;
use App\Domain\Activity\AdventureActivity\AdventureActivity;
use App\Infrastructure\Repository\Activity\ActivityRepositoryMySQL;
use App\Domain\Activity\ActivityRepository\ActivityRepositoryCriteria;
use App\Domain\Activity\AdventureActivity\Repository\AdventureActivityRepositoryCriteria;
use App\Domain\Activity\AdventureActivity\AdventureActivityEquipment\AdventureActivityEquipmentCollection;
use Doctrine\DBAL\ArrayParameterType;

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

    public function findByCriteria(ActivityRepositoryCriteria $criteria): ActivityCollection
    {

        $activitiesData = parent::getResult(
            $criteria,
            self::TYPE_CONVERSION[ActivityType::ADVENTURE_ACTIVITY_TYPE]
        );

        if (empty($activitiesData)) {
            return new ActivityCollection();
        }

        $parameters = ['ids' => \array_keys($activitiesData)];
        $where = ' WHERE activity_id IN (:ids)';
        $types = ['ids' => ArrayParameterType::INTEGER];

        /** @var AdventureActivityRepositoryCriteria $criteria */
        if ($criteria->hasEquipment()) {
            $adventureIds = \array_keys($this->connection->executeQuery(
                'SELECT * FROM adventure_activity WHERE equipment_name = :equipment',
                ['equipment' => $criteria->getEquipment()->getValue()],
                $types
            )->fetchAllAssociativeIndexed());

            $parameters['ids'] = \array_merge($adventureIds, $parameters['ids']);
        }

        $adventuresData = $this->connection->executeQuery(
            'SELECT * FROM adventure_activity' . $where,
            $parameters,
            $types
        )->fetchAllAssociative();

        $indexedAdventures = [];
        foreach ($adventuresData as $adventureData) {
            if (!\array_key_exists($adventureData['activity_id'], $indexedAdventures)) {
                $indexedAdventures[$adventureData['activity_id']] = [];
            }
            $indexedAdventures[$adventureData['activity_id']][] = $adventureData['equipment_name'];
        }

        return $this->buildCollection(
            $indexedAdventures,
            $activitiesData,
            $criteria->hasEquipment()
        );
    }

    private function buildCollection(
        array $adventuresData,
        array $activitiesData,
        bool $usedCriteria
    ): ActivityCollection {
        $activitiesCollection = new ActivityCollection();
        foreach ($adventuresData as $activityId => $adventureData) {
            $activitiesCollection->addActivity(
                $this->buildActivity(
                    $adventureData,
                    $activitiesData[$activityId],
                    $activityId
                )
            );
        }

        if (!$usedCriteria) {
            foreach ($activitiesData as $activityId => $activityData) {
                if (\array_key_exists($activityId, $adventuresData)) {
                    continue;
                }
                $activitiesCollection->addActivity(
                    $this->buildActivity(
                        [],
                        $activityData,
                        $activityId
                    )
                );
            }
        }

        return $activitiesCollection;
    }

    private function buildActivity(array $equipments, array $activityData, int $activityId): AdventureActivity
    {
        $activity = new AdventureActivity(
            new ActivityName($activityData['name']),
            new ActivityDescription($activityData['description']),
            AdventureActivityEquipmentCollection::createFromArray($equipments)
        );
        $activity->setId(new ActivityId($activityId));

        return $activity;
    }
}
