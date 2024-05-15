<?php
    namespace fop\Exception;
    class ErrorCode
    {
        public static $OK = 0;
        public static $reqKeyEncodeFail = -41001;
        public static $reqKeyDecodeFail = -41002;

        public static $reqBodyEncodeFail = -41003;
        public static $reqBodyDecodeFail = -41004;
        public static $aesEncodeFail = -41005;
        public static $aesDecodeFail = -41006;
        public static $rsaEncodeFail = -41007;
        public static $rsaDecodeFail = -41008;
        public static $signEncodeFail = -41009;
        public static $signDecodeFail = -41010;

        public static function getCodeMsg(int $code):string {
            return [
                self::$OK => 'OK',
                self::$reqKeyEncodeFail => 'enReqKey 加密失败',
                self::$reqKeyDecodeFail => 'enReqKey 解密失败',
                self::$reqBodyEncodeFail => 'encReqBody 加密失败',
                self::$reqBodyDecodeFail => 'encReqBody 解密失败',
                self::$aesEncodeFail => 'aes 加密失败',
                self::$aesDecodeFail => 'aes 解密失败',
                self::$rsaEncodeFail => 'rsa 加密失败',
                self::$rsaDecodeFail => 'rsa 解密失败',
                self::$signEncodeFail => 'sign 加密失败',
                self::$signDecodeFail => 'sign 解密失败',
            ][$code];
        }
     }