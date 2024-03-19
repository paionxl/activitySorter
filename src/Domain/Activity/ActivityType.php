<?php

namespace App\Domain\Activity;

class ActivityType
{
    private string $type;

    /** @var ActivityType[] */
    private static array $instances = [];

    public const ONLINE_GAME_ACTIVITY_TYPE = 0;
    public const ADVENTURE_ACTIVITY_TYPE = 1;
    public const SPORTS_ACTIVITY_TYPE = 2;

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
            throw new \Exception('Activity type not allowed: ' . $type);
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
}
