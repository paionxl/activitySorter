<?php

namespace App\Infrastructure\Repository\Activity\SportsActivity;

use App\Domain\Activity\Activity;
use App\Domain\Activity\ActivityId;
use App\Domain\Activity\ActivityName;
use App\Domain\Activity\ActivityType;
use Doctrine\DBAL\ArrayParameterType;
use App\Domain\Activity\ActivityCollection;
use App\Domain\Activity\ActivityDescription;
use App\Domain\Activity\AdventureActivity\SportsActivity;
use App\Domain\Activity\SportsActivity\SportsActivityType;
use App\Infrastructure\Repository\Activity\ActivityRepositoryMySQL;
use App\Domain\Activity\ActivityRepository\ActivityRepositoryCriteria;
use App\Domain\Activity\AdventureActivity\Repository\SportsActivityRepositoryCriteria;

class SportsActivityRepositoryMySQL extends ActivityRepositoryMySQL
{
    public function add(Activity $activity): ActivityId
    {
        try {
            $this->connection->beginTransaction();

            /** @var SportsActivity $activity */
            $activityId = parent::add($activity);

            $query = 'INSERT INTO sports_activity (activity_id, sports_type) VALUES (:id, :sports_type)';
            $this->connection->executeQuery(
                $query,
                [
                    'id' => $activityId->getValue(),
                    'sports_type' => $activity->getSportsActivityType()->getValue()
                ]
            );
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
            self::TYPE_CONVERSION[ActivityType::SPORTS_ACTIVITY_TYPE]
        );

        if (empty($activitiesData)) {
            return new ActivityCollection();
        }

        $parameters = ['ids' => \array_keys($activitiesData)];
        $where = ' WHERE activity_id IN (:ids)';
        $types = ['ids' => ArrayParameterType::INTEGER];

        /** @var SportsActivityRepositoryCriteria $criteria */

        if ($criteria->hasSportsActivityType()) {
            $parameters['sports_type'] = $criteria->getSportsActivityType()->getValue();
            $where .= ' AND sports_type = :sports_type';
        }

        $sportsData = $this->connection->executeQuery(
            'SELECT * FROM sports_activity' . $where,
            $parameters,
            $types
        )->fetchAllAssociativeIndexed();

        return $this->buildCollection(
            $sportsData,
            $activitiesData
        );
    }

    private function buildCollection(
        array $sportsActivitiesData,
        array $activitiesData
    ): ActivityCollection {
        $activitiesCollection = new ActivityCollection();

        foreach ($sportsActivitiesData as $activityId => $sportsActivityData) {
            $activitiesCollection->addActivity(
                $this->buildActivity(
                    $sportsActivityData,
                    $activitiesData[$activityId],
                    $activityId
                )
            );
        }

        return $activitiesCollection;
    }

    private function buildActivity(array $sportsData, array $activityData, int $activityId): SportsActivity
    {
        $activity = new SportsActivity(
            new ActivityName($activityData['name']),
            new ActivityDescription($activityData['description']),
            new SportsActivityType($sportsData['sports_type'])
        );
        $activity->setId(new ActivityId($activityId));

        return $activity;
    }
}
