<?php

namespace fop\Traits;

trait FormatTrait
{
    protected $format;

    public function setFormat(string $format): void
    {
        $this->format = $format;
    }
    public function getFormat(): string {
        return $this->format;
    }
}
