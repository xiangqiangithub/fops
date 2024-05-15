<?php

namespace fop\Traits;

trait TimestampFormatTrait
{
    protected $timestampFormat;

    public function setTimestampFormat(string $timestampFormat): void
    {
        $this->timestampFormat = $timestampFormat;
    }
    public function getTimestampFormat(): string
    {
        return $this->timestampFormat;
    }
    public function getTimestamp(): string
    {
        return date($this->timestampFormat,time());
    }
}