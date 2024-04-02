<?php

namespace App\Infrastructure\Repository\Activity\OnlineGameActivity;

use App\Domain\Activity\Activity;
use App\Domain\Activity\ActivityId;
use App\Domain\Activity\ActivityName;
use App\Domain\Activity\ActivityType;
use Doctrine\DBAL\ArrayParameterType;
use App\Domain\Activity\ActivityCollection;
use App\Domain\Activity\ActivityDescription;
use App\Domain\Activity\OnlineGameActivity\OnlineGameActivity;
use App\Infrastructure\Repository\Activity\ActivityRepositoryMySQL;
use App\Domain\Activity\ActivityRepository\ActivityRepositoryCriteria;
use App\Domain\Activity\OnlineGameActivity\OnlineGameActivityPlatform;
use App\Domain\Activity\OnlineGameActivity\Repository\OnlineGameActivityRepositoryCriteria;

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

    public function findByCriteria(ActivityRepositoryCriteria $criteria): ActivityCollection
    {
        $activitiesData = parent::getResult(
            $criteria,
            self::TYPE_CONVERSION[ActivityType::ONLINE_GAME_ACTIVITY_TYPE]
        );

        if (empty($activitiesData)) {
            return new ActivityCollection();
        }

        $parameters = ['ids' => \array_keys($activitiesData)];
        $where = ' WHERE activity_id IN (:ids)';
        $types = ['ids' => ArrayParameterType::INTEGER];

        /** @var OnlineGameActivityRepositoryCriteria $criteria */

        if ($criteria->hasPlatform()) {
            $parameters['platform'] = $criteria->getPlatform()->getValue();
            $where .= ' AND ' . 'platform = :platform';
        }

        $onlineGamesData = $this->connection->executeQuery(
            'SELECT * FROM online_game_activity' . $where,
            $parameters,
            $types
        )->fetchAllAssociativeIndexed();

        return $this->buildCollection(
            $onlineGamesData,
            $activitiesData
        );
    }

    private function buildCollection(
        array $onlineGamesData,
        array $activitiesData
    ): ActivityCollection {
        $activitiesCollection = new ActivityCollection();

        foreach ($onlineGamesData as $activityId => $onlineGameData) {
            $activitiesCollection->addActivity(
                $this->buildActivity(
                    $onlineGameData,
                    $activitiesData[$activityId],
                    $activityId
                )
            );
        }

        return $activitiesCollection;
    }

    private function buildActivity(array $onlineGameData, array $activityData, int $activityId): OnlineGameActivity
    {
        $activity = new OnlineGameActivity(
            new ActivityName($activityData['name']),
            new ActivityDescription($activityData['description']),
            new OnlineGameActivityPlatform($onlineGameData['platform'])
        );
        $activity->setId(new ActivityId($activityId));

        return $activity;
    }
}
