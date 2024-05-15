<?php

namespace fop\Traits;

trait SignTypeTrait
{
    protected $signType;

    public function setSignType(string $signType): void
    {
        $this->signType = $signType;
    }
    public function getSignType(): string {
        return $this->signType;
    }
}

