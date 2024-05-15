<?php

namespace fop\Traits;

use fop\Util\AESUtil;

trait CipherTrait
{
    protected $cipher;

    public function setCipher(string $cipher): void
    {
        AESUtil::$cipher = $cipher;
        $this->cipher = $cipher;
    }
    public function getCipher(): string {
        return $this->cipher;
    }
}

