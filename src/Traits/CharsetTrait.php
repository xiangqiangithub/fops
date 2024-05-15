<?php

namespace fop\Traits;

trait CharsetTrait
{
    protected $charset;

    public function setCharset(string $charset): void
    {
        $this->charset = $charset;
    }
    public function getCharset(): string {
        return $this->charset;
    }
}
