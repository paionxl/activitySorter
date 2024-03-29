<?php

namespace App\Infrastructure\Repository\Activity\OnlineGameActivity;

use App\Domain\Activity\Activity;
use App\Domain\Activity\ActivityId;
use App\Domain\Activity\OnlineGameActivity\OnlineGameActivity;
use App\Infrastructure\Repository\Activity\ActivityRepositoryMySQL;

class OnlineGameActivityRepositoryMySQL extends ActivityRepositoryMySQL
{
    public function add(Activity $activity): ActivityId
    {
        try {
            $this->connection->beginTransaction();
            
            /** @var OnlineGameActivity $activity */
            $activityId = parent::add($activity);

            $query = 'INSERT INTO online_game_activity (activity_id, platform) VALUES (:id, :platform)';
            $this->connection->executeQuery(
                $query,
                [
                    'id' => $activityId->getValue(),
                    'platform' => $activity->getPlatform()->getValue()
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
