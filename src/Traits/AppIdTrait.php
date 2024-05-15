<?php

namespace fop\Traits;

trait AppIdTrait
{
    protected $appId;

    public function setAppId(int $appId): void
    {
        $this->appId = $appId;
    }
    public function getAppId(): int {
        return $this->appId;
    }
}
