<?php

namespace Tests\Domain\Activity;

use PHPUnit\Framework\TestCase;
use App\Domain\Activity\ActivityType;
use App\Exception\ActivitySorterException;

class ActivityTypeTest extends TestCase
{
    public function testEqualsWorksCorrectly(): void
    {
        self::assertTrue(
            ActivityType::instance(ActivityType::ADVENTURE_ACTIVITY_TYPE)->equals(
                ActivityType::instance(ActivityType::ADVENTURE_ACTIVITY_TYPE)
            )
        );

        self::assertFalse(
            ActivityType::instance(ActivityType::ADVENTURE_ACTIVITY_TYPE)->equals(
                ActivityType::instance(ActivityType::ONLINE_GAME_ACTIVITY_TYPE)
            )
        );
    }

    public function testInstanceWorksCorrectly(): void
    {
        self::assertSame(
            ActivityType::ADVENTURE_ACTIVITY_TYPE,
            ActivityType::instance(ActivityType::ADVENTURE_ACTIVITY_TYPE)->getValue()
        );

        self::assertSame(
            ActivityType::instance(ActivityType::ADVENTURE_ACTIVITY_TYPE),
            ActivityType::instance(ActivityType::ADVENTURE_ACTIVITY_TYPE)
        );
    }

    public function testInstanceThrowsExceptionWhenInvalidType(): void
    {
        $this->expectException(ActivitySorterException::class);
        $this->expectExceptionMessage('Activity type not allowed: an invalid type');
        ActivityType::instance('an invalid type');
    }
}
