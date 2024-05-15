<?php

namespace fop\Traits;

    trait RsaPublicKeyTrait
    {
        protected $rsaPublicKey;

        public function setRsaPublicKey(string $rsaPublicKey): void
        {
            $this->rsaPublicKey = $rsaPublicKey;
        }
        public function getRsaPublicKey(): string
        {
            return $this->rsaPublicKey;
        }
    }
