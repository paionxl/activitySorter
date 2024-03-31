<?php

namespace Tests\Domain\Activity\OnlineGameActivity;

use PHPUnit\Framework\TestCase;
use App\Domain\Activity\ActivityName;
use App\Domain\Activity\ActivityType;
use App\Domain\Activity\ActivityDescription;
use PHPUnit\Framework\MockObject\MockObject;
use App\Domain\Activity\OnlineGameActivity\OnlineGameActivity;
use App\Domain\Activity\OnlineGameActivity\OnlineGameActivityPlatform;

class OnlineGameActivityTest extends TestCase
{
    /** @var ActivityName&MockObject */
    private ActivityName $activityName;

    /** @var ActivityDescription&MockObject */
    private ActivityDescription $activityDescription;

    /** @var OnlineGameActivityPlatform&MockObject */
    private OnlineGameActivityPlatform $onlineGameActivityPlatform;

    private OnlineGameActivity $sut;

    protected function setUp(): void
    {
        $this->activityName = $this->createMock(ActivityName::class);
        $this->activityDescription = $this->createMock(ActivityDescription::class);
        $this->onlineGameActivityPlatform = $this->createMock(OnlineGameActivityPlatform::class);
        $this->sut = new OnlineGameActivity(
            $this->activityName,
            $this->activityDescription,
            $this->onlineGameActivityPlatform
        );
    }

    public function testConstructorTypeWorksCorrectly(): void
    {
        self::assertSame(
            ActivityType::instance(ActivityType::ONLINE_GAME_ACTIVITY_TYPE),
            $this->sut->getActivityType()
        );
    }

    public function testGetPlatformWorksCorrectly(): void
    {
        self::assertSame(
            $this->onlineGameActivityPlatform,
            $this->sut->getPlatform()
        );
    }
}
