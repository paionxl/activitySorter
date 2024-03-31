<?php

namespace Tests\Application\Activity\Adapter;

use PHPUnit\Framework\TestCase;
use App\Domain\Activity\Activity;
use App\Domain\Activity\ActivityType;
use App\Exception\ActivitySorterException;
use App\Domain\Activity\ActivityCollection;
use PHPUnit\Framework\MockObject\MockObject;
use App\Application\Activity\Adapter\ActivityCollectionAdapter;
use App\Application\Activity\AdventureActivity\Adapter\AdventureActivityAdapter;
use App\Application\Activity\OnlineGameActivity\Adapter\OnlineGameActivityAdapter;

class ActivityCollectionAdapterTest extends TestCase
{
    /** @var AdventureActivityAdapter&MockObject */
    private AdventureActivityAdapter $adventureActivityAdapter;

    /** @var OnlineGameActivityAdapter&MockObject */
    private OnlineGameActivityAdapter $onlineGameActivityAdapter;

    private ActivityCollectionAdapter $sut;

    protected function setUp(): void
    {
        $this->adventureActivityAdapter = $this->createMock(AdventureActivityAdapter::class);
        $this->onlineGameActivityAdapter = $this->createMock(OnlineGameActivityAdapter::class);

        $this->sut = new ActivityCollectionAdapter([
            'adventure_activity' => $this->adventureActivityAdapter,
            'online_game_activity' => $this->onlineGameActivityAdapter
        ]);
    }

    public function testAdaptThrowsExceptionIfInvalidType(): void
    {
        $this->expectException(ActivitySorterException::class);
        $this->expectExceptionMessage(
            'Adapter for activity type random type not implemented.'
        );

        $activityType = $this->createMock(ActivityType::class);
        $activityType
            ->expects(self::exactly(2))
            ->method('getValue')
            ->willReturn('random type');

        $activity = $this->createMock(Activity::class);
        $activity
            ->expects(self::exactly(2))
            ->method('getActivityType')
            ->willReturn($activityType);

        $activityCollection = $this->createMock(ActivityCollection::class);
        $activityCollection
            ->expects(self::once())
            ->method('getActivities')
            ->willReturn([$activity]);

        $this->sut->adapt($activityCollection);
    }

    /** @dataProvider dataProvider */
    public function testAdaptWorksCorrectly(
        ActivityCollection $activityCollection,
        array $adventureActivityAdapterMap,
        int $adventureActivityAdapterTimesCalled,
        array $onlineGameActivityAdapterMap,
        int $onlineGameActivityAdapterTimesCalled,
        array $expectedOutput
    ): void {
        $this->adventureActivityAdapter
            ->expects(self::exactly($adventureActivityAdapterTimesCalled))
            ->method('adapt')
            ->willReturnMap($adventureActivityAdapterMap);

        $this->onlineGameActivityAdapter
            ->expects(self::exactly($onlineGameActivityAdapterTimesCalled))
            ->method('adapt')
            ->willReturnMap($onlineGameActivityAdapterMap);

        self::assertSame($expectedOutput, $this->sut->adapt($activityCollection));
    }

    public function dataProvider(): array
    {
        return [
            'empty_case' => $this->getEmptyCase(),
            'simple_case' => $this->getSimpleCase(),
            'full_case' => $this->getFullCase()
        ];
    }

    private function getEmptyCase(): array
    {
        $activityCollection = $this->createMock(ActivityCollection::class);
        $activityCollection
            ->expects(self::once())
            ->method('getActivities')
            ->willReturn([]);

        return [
            'activity_collection' => $activityCollection,
            'adventure_activity_adapter_map' => [],
            'adventure_activity_adapter_times_called' => 0,
            'online_game_activity_adapter_map' => [],
            'online_game_activity_times_called' => 0,
            'expected_output' => []
        ];
    }

    private function getSimpleCase(): array
    {
        $activityType = $this->createMock(ActivityType::class);
        $activityType
            ->expects(self::exactly(2))
            ->method('getValue')
            ->willReturn('online_game_activity');

        $activity = $this->createMock(Activity::class);
        $activity
            ->expects(self::exactly(2))
            ->method('getActivityType')
            ->willReturn($activityType);

        $activityCollection = $this->createMock(ActivityCollection::class);
        $activityCollection
            ->expects(self::once())
            ->method('getActivities')
            ->willReturn([$activity]);

        return [
            'activity_collection' => $activityCollection,
            'adventure_activity_adapter_map' => [],
            'adventure_activity_adapter_times_called' => 0,
            'online_game_activity_adapter_map' => [
                [$activity, ['an adapted activity']]
            ],
            'online_game_activity_times_called' => 1,
            'expected_output' => [
                ['an adapted activity']
            ],
            'inner' => [$activityType]
        ];
    }

    private function getFullCase(): array
    {
        $activityType = $this->createMock(ActivityType::class);
        $activityType
            ->expects(self::exactly(2))
            ->method('getValue')
            ->willReturn('online_game_activity');

        $activity = $this->createMock(Activity::class);
        $activity
            ->expects(self::exactly(2))
            ->method('getActivityType')
            ->willReturn($activityType);

        $activityType2 = $this->createMock(ActivityType::class);
        $activityType2
            ->expects(self::exactly(2))
            ->method('getValue')
            ->willReturn('adventure_activity');

        $activity2 = $this->createMock(Activity::class);
        $activity2
            ->expects(self::exactly(2))
            ->method('getActivityType')
            ->willReturn($activityType2);

        $activityType3 = $this->createMock(ActivityType::class);
        $activityType3
            ->expects(self::exactly(2))
            ->method('getValue')
            ->willReturn('online_game_activity');

        $activity3 = $this->createMock(Activity::class);
        $activity3
            ->expects(self::exactly(2))
            ->method('getActivityType')
            ->willReturn($activityType3);

        $activityCollection = $this->createMock(ActivityCollection::class);
        $activityCollection
            ->expects(self::once())
            ->method('getActivities')
            ->willReturn([$activity, $activity2, $activity3]);

        return [
            'activity_collection' => $activityCollection,
            'adventure_activity_adapter_map' => [
                [$activity2, ['an adapted activity2']]
            ],
            'adventure_activity_adapter_times_called' => 1,
            'online_game_activity_adapter_map' => [
                [$activity, ['an adapted activity']],
                [$activity3, ['an adapted activity3']]
            ],
            'online_game_activity_times_called' => 2,
            'expected_output' => [
                ['an adapted activity'],
                ['an adapted activity2'],
                ['an adapted activity3']
            ],
            'inner' => [$activityType, $activityType2, $activityType3]
        ];

    }
}
