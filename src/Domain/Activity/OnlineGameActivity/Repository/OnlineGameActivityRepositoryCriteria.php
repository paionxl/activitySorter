<?php

namespace App\Domain\Activity\AdventureActivity\Repository;

use App\Domain\Activity\ActivityRepository\ActivityRepositoryCriteria;
use App\Domain\Activity\OnlineGameActivity\OnlineGameActivityPlatform;

class OnlineGameActivityRepositoryCriteria extends ActivityRepositoryCriteria
{
    private OnlineGameActivityPlatform $platform;

    public function getPlatform(): OnlineGameActivityPlatform
    {
        return $this->platform;
    }

    public function setPlatform(OnlineGameActivityPlatform $platform): void
    {
        $this->platform = $platform;
    }

    public function hasPlatform(): bool
    {
        return isset($this->platform);
    }
}
