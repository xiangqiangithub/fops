<?php

namespace fop\Traits;

trait RsaPrivateKeyTrait
{
    protected $rsaPrivateKey;

    public function setRsaPrivateKey(string $rsaPrivateKey): void
    {
        $this->rsaPrivateKey = $rsaPrivateKey;
    }
    public function getRsaPrivateKey(): string
    {
        return $this->rsaPrivateKey;
    }
}

