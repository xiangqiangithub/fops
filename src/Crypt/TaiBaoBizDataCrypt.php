<?php
namespace fop\Crypt;

use fop\out\FopOutUtil;
use fop\Traits\CipherTrait;
use fop\Traits\RsaPrivateKeyTrait;
use fop\Traits\RsaPublicKeyTrait;
use fop\Util\AESUtil;
use Exception;

class TaiBaoBizDataCrypt
{
    use RsaPublicKeyTrait,RsaPrivateKeyTrait,CipherTrait;

    /**
     * @throws Exception
     */
    public function getReqBody(string $content):string {
        return  FopOutUtil::reqDec($content,$this->rsaPrivateKey);
    }

    /**
     * @throws Exception
     */
    public function getRespBody(string $content):array {
        return FopOutUtil::respEnc($content,$this->rsaPublicKey);
    }
}

