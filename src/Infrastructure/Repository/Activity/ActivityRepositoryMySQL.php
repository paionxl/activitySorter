<?php

namespace App\Infrastructure\Repository\Activity;

use App\Domain\Activity\Activity;
use App\Domain\Activity\ActivityId;
use App\Domain\Activity\ActivityCollection;
use App\Domain\Activity\ActivityRepository\ActivityRepositoryCriteria;
use App\Domain\Activity\ActivityRepository\ActivityRepositoryInterface;
use App\Domain\Activity\ActivityType;
use App\Exception\ActivitySorterException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

abstract class ActivityRepositoryMySQL implements ActivityRepositoryInterface
{
    private const TYPE_CONVERSION = [
        ActivityType::ONLINE_GAME_ACTIVITY_TYPE => 0,
        ActivityType::ADVENTURE_ACTIVITY_TYPE => 1,
        ActivityType::SPORTS_ACTIVITY_TYPE => 2
    ];

    protected Connection $connection;

    public function __construct()
    {
        $connectionParams = array(
            'url' => $_ENV['DATABASE_URL']
        );
        $this->connection = DriverManager::getConnection($connectionParams);
    }

    public function add(Activity $activity): ActivityId
    {
        $activityType = $activity->getActivityType()->getValue();
        if (!\array_key_exists($activity->getActivityType()->getValue(), self::TYPE_CONVERSION)) {
            throw new ActivitySorterException('Activity type not mapped in repository :' . $activityType);
        }

        $query = 'INSERT INTO db.activity (name, description, type) VALUES (:name, :description, :type)';
        $this->connection->executeQuery(
            $query,
            [
                'name' => $activity->getActivityName()->getValue(),
                'description' => $activity->getActivityDescription()->getValue(),
                'type' => self::TYPE_CONVERSION[$activityType]
        ]);

        return new ActivityId($this->connection->lastInsertId());
    }

    public function findByCriteria(ActivityRepositoryCriteria $criteria): ActivityCollection
    {
        return new ActivityCollection();
    }
}
