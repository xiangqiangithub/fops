<?php

namespace fop\Http;

use fop\Traits\ApiCodeTrait;
use fop\Traits\AppIdTrait;
use fop\Traits\CharsetTrait;
use fop\Traits\CipherTrait;
use fop\Traits\FormatTrait;
use fop\Traits\RsaPrivateKeyTrait;
use fop\Traits\RsaPublicKeyTrait;
use fop\Traits\SignTypeTrait;
use fop\Traits\TimestampFormatTrait;
use fop\Traits\VersionTrait;

class Config
{
    use AppIdTrait,CharsetTrait,CipherTrait,FormatTrait,RsaPublicKeyTrait;
    use RsaPrivateKeyTrait,SignTypeTrait,TimestampFormatTrait,VersionTrait;
    use ApiCodeTrait;
    public function getNonce():string {
        return md5(uniqid('', true));
    }
}

