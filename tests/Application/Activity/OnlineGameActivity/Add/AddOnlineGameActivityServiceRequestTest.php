<?php

namespace Tests\Application\Activity\OnlineGameActivity\Add;

use App\Application\Activity\OnlineGameActivity\Add\AddOnlineGameActivityServiceRequest;
use PHPUnit\Framework\TestCase;

class AddOnlineGameActivityServiceRequestTest extends TestCase
{
    private AddOnlineGameActivityServiceRequest $sut;

    protected function setUp(): void
    {
        $this->sut = new AddOnlineGameActivityServiceRequest(
            'a name',
            'a description',
            'a platform'
        );
    }

    public function testParentMethodsWorkCorrectly(): void
    {
        self::assertSame('online_game_activity', $this->sut->getType());
        self::assertSame('a name', $this->sut->getName());
        self::assertSame('a description', $this->sut->getDescription());
    }

    public function testGetPlatformWorksCorrectly(): void
    {
        self::assertSame('a platform', $this->sut->getPlatform());
    }
}
