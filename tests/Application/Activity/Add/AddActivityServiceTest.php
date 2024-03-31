<?php

namespace Tests\Application\Activity\Add;

use PHPUnit\Framework\TestCase;
use App\Domain\Activity\Activity;
use App\Domain\Activity\ActivityId;
use PHPUnit\Framework\MockObject\MockObject;
use App\Application\Activity\Add\AddActivityService;
use App\Application\Activity\AdventureActivity\Add\AddAdventureActivityServiceRequest;
use App\Domain\Activity\ActivityRepository\ActivityRepositoryInterface;
use App\Application\Activity\OnlineGameActivity\Add\AddOnlineGameActivityService;
use App\Application\Activity\OnlineGameActivity\Add\AddOnlineGameActivityServiceRequest;
use App\Exception\ActivitySorterException;

class AddActivityServiceTest extends TestCase
{
    private AddActivityService $sut;

    /** @var ActivityRepositoryInterface&MockObject */
    private ActivityRepositoryInterface $activityRepository;

    protected function setUp(): void
    {
        $this->activityRepository = $this->createMock(ActivityRepositoryInterface::class);
        $this->sut = new AddOnlineGameActivityService($this->activityRepository);
    }

    public function testAddWorksCorrectly(): void
    {
        $activityId = $this->createMock(ActivityId::class);
        $activityId
            ->expects(self::once())
            ->method('getValue')
            ->willReturn(5);

        $this->activityRepository
            ->expects(self::once())
            ->method('add')
            ->with($this->isInstanceOf(Activity::class))
            ->willReturn($activityId);

        $addActivityServiceRequest = $this->createMock(AddOnlineGameActivityServiceRequest::class);
        $addActivityServiceRequest
            ->expects(self::once())
            ->method('getName')
            ->willReturn('a name');
        $addActivityServiceRequest
            ->expects(self::once())
            ->method('getDescription')
            ->willReturn('a description');
        $addActivityServiceRequest
            ->expects(self::once())
            ->method('getPlatform')
            ->willReturn('a platform');
        $addActivityServiceRequest
            ->expects(self::once())
            ->method('getType')
            ->willReturn('online_game_activity');

        self::assertSame(5, $this->sut->add($addActivityServiceRequest));
    }

    public function testAddThrowsExceptionIfTypeNotValid()
    {
        $this->expectException(ActivitySorterException::class);
        $this->expectExceptionMessage('Type not valid. Expected online_game_activity and got adventure_activity');
        $this->activityRepository
            ->expects(self::never())
            ->method('add');

        $addActivityServiceRequest = $this->createMock(AddAdventureActivityServiceRequest::class);
        $addActivityServiceRequest
            ->expects(self::exactly(2))
            ->method('getType')
            ->willReturn('adventure_activity');

        self::assertSame(5, $this->sut->add($addActivityServiceRequest));
    }
}
