<?php
    namespace fop\Internal\Util;
    use fop\Exception\AesException;
    use fop\Exception\ErrorCode;
    use fop\Exception\RsaException;
    use fop\Exception\SignException;
    use fop\Util\AESUtil;
    use fop\Util\RSAUtil;
    use fop\Util\StringUtil;

    class FopSignature {

        /**
         * @throws RsaException
         */
        public static function rsa2Decrypt($encReqKey, $privateKey): string
        {
            $result = '';
            if(!RSAUtil::rsaDecrypt($privateKey,base64_decode($encReqKey),$result)){
                throw new RsaException(ErrorCode::getCodeMsg(ErrorCode::$rsaDecodeFail),ErrorCode::$rsaDecodeFail);
            }
            return $result;
        }

        /**
         * @throws RsaException
         */
        public static function rsa2Encrypt($encReqKey, $privateKey): string {
            $decrypted = '';
            if(!RSAUtil::rsaEncrypt($privateKey,$encReqKey,$decrypted)){
                throw new RsaException(ErrorCode::getCodeMsg(ErrorCode::$rsaEncodeFail),ErrorCode::$rsaEncodeFail);
            }
            return $decrypted;
        }

        /**
         * @throws AesException
         */
        public static function aesEncrypt(string $key, string $data): string {
            $res = AESUtil::aesEncrypt($key,$data);
            if(!$res){
                throw new AesException(ErrorCode::getCodeMsg(ErrorCode::$aesEncodeFail),ErrorCode::$aesEncodeFail);
            }
            return $res;

        }

        /**
         * @throws AesException
         */
        public static function aesDecrypt(string $key, string $data): string {
            $res = AESUtil::aesDecrypt(base64_decode($key),base64_decode($data));
            if(!$res){
                throw new AesException(ErrorCode::getCodeMsg(ErrorCode::$aesDecodeFail),ErrorCode::$aesDecodeFail);
            }
            return $res;
        }
        public static function getSignContent(array $data): string
        {
            foreach ($data as $k=>$v){
                if(!StringUtil::areNotEmpty([$k,$v])){
                    unset($data[$k]);
                }
            }
            if(empty($data)){
                return "";
            }
            ksort($data);
            return http_build_query($data);
        }

        /**
         * @throws SignException
         */
        public static function getSign(string $publicKey, string $content): string {
            $encryptedData = "";
            $res = RSAUtil::rsa256Encrypt($publicKey,$content,$encryptedData);
            if(!$res){
                throw  new SignException(ErrorCode::getCodeMsg(Errorcode::$signEncodeFail),ErrorCode::$signEncodeFail);
            }
            return base64_encode($encryptedData);
        }
    }