<?php

namespace fop\Out;

use fop\Internal\Util\FopSignature;
use fop\Util\AESUtil;
use Exception;

class FopOutUtil {
    /**
     * @throws Exception
     */
    public static function reqDec(string $reqBody, string $privateKey):string
    {
        $reqJson = json_decode($reqBody, true);
        $encReqKey = $reqJson["encReqKey"] ?? '';
        $encryptReqBody = $reqJson["encReqBody"] ?? '';
        $decReqKey = FopSignature::rsa2Decrypt($encReqKey, $privateKey);
        return FopSignature::aesDecrypt($decReqKey,$encryptReqBody);

    }

    /**
     * @throws Exception
     */
    public static function respEnc(string $reqBody, string $fopPublicKey):array {
        $respKey = AESUtil::generateAesKey();
        $encRespBody = FopSignature::aesEncrypt($respKey, $reqBody);
        $encRespKey = FopSignature::rsa2Encrypt(base64_encode($respKey), $fopPublicKey);
        return ['encReqKey' => base64_encode($encRespKey), 'encReqBody' => base64_encode($encRespBody)];
    }
}
