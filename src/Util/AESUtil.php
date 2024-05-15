<?php

namespace fop\Util;
class AESUtil {
    static $cipher='AES-256-CBC';
    public static function aesEncrypt(string $key,string $data): string {
        return openssl_encrypt($data, self::$cipher, $key,OPENSSL_RAW_DATA,self::initIv());
    }
    public static function aesDecrypt(string $key, string $data) {
        return openssl_decrypt($data, self::$cipher, $key,OPENSSL_RAW_DATA,self::initIv());
    }
    public static function generateAESKey($keyLength = 32): string
    {
        return openssl_random_pseudo_bytes($keyLength);
    }
     public static function initIv():string {
         return str_repeat(chr(0),openssl_cipher_iv_length(self::$cipher));
    }
}