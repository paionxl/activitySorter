<?php

namespace App\Infrastructure\Repository\Activity\SportsActivity;

use App\Domain\Activity\Activity;
use App\Domain\Activity\ActivityId;
use App\Domain\Activity\AdventureActivity\SportsActivity;
use App\Infrastructure\Repository\Activity\ActivityRepositoryMySQL;

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
}
