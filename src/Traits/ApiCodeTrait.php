<?php

namespace fop\Traits;

trait ApiCodeTrait
{
    protected $appCode;

    public function setAppCode(string $appCode): void
    {
        $this->appCode = $appCode;
    }
    public function getAppCode(): string {
        return $this->appCode;
    }
}

