<?php

namespace fop\Traits;

trait VersionTrait
{
    protected $version;

    public function setVersion(string $version): void
    {
        $this->version = $version;
    }
    public function getVersion(): string {
        return $this->version;
    }
}
