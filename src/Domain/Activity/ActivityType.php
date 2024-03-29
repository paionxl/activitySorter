<?php

namespace App\Domain\Activity;

use App\Exception\ActivitySorterException;

class ActivityType
{
    private string $type;

    /** @var ActivityType[] */
    private static array $instances = [];

    public const ONLINE_GAME_ACTIVITY_TYPE = 'online_game_activity';
    public const ADVENTURE_ACTIVITY_TYPE = 'adventure_activity';
    public const SPORTS_ACTIVITY_TYPE = 'sports_activity';

    private const ALLOWED_TYPES = [
        self::ONLINE_GAME_ACTIVITY_TYPE,
        self::ADVENTURE_ACTIVITY_TYPE,
        self::SPORTS_ACTIVITY_TYPE
    ];

    private function __construct(string $type)
    {
        $this->type = $type;
    }

    public static function instance(string $type): ActivityType
    {
        if (!\in_array($type, self::ALLOWED_TYPES)) {
            throw new ActivitySorterException('Activity type not allowed: ' . $type);
        }

        if (!\array_key_exists($type, self::$instances)) {
            self::$instances[$type] = new self($type);
        }

        return self::$instances[$type];
    }

    public function getValue(): string
    {
        return $this->type;
    }

    public function equals(ActivityType $activityType): bool
    {
        return $this->type === $activityType->getValue();
    }
}
