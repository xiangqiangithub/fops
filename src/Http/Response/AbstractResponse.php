<?php
namespace fop\Http\Response;
use GuzzleHttp\Psr7\Response;

abstract class AbstractResponse extends Response {
    protected $rsaPrivateKey;

    abstract public function toArray(): array;
    public function setRsaPrivateKey($rsaPrivateKey)
    {
        $this->rsaPrivateKey = $rsaPrivateKey;
    }
}
