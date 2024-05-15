<?php

namespace fop\Util;

class RSAUtil {
    public static $algorithm = OPENSSL_ALGO_SHA256;
    public static function rsaEncrypt(string $publicKey,string $data,string &$encryptedData): bool
    {
        return openssl_public_encrypt($data, $encryptedData,$publicKey);
    }
    public static function rsaDecrypt(string $privateKey, string $data, string &$decryptData): bool
    {
        return openssl_private_decrypt($data, $decryptData, $privateKey);
    }
    public static function rsa256Encrypt(string $publicKey,string $data,string &$encryptedData): bool{
        return openssl_sign($data, $encryptedData,$publicKey,self::$algorithm);
    }
    public static function verifyRsa256Encrypt(string $data,string $signature,string $publicKey): bool{
        return openssl_verify($data, $signature, $publicKey, self::$algorithm);
    }
}
