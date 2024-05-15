<?php

namespace fop\Util;
use IntlChar;

class StringUtil
{
    public static function isEmpty(string $str): bool
    {
        if ($str == null || strlen($str)==0 ||'null' == strtolower($str)) {
            return true;
        }
        $strLen = strlen($str);
        for ($i = 0; $i < $strLen; $i++) {
            if (!IntlChar::iswhitespace($str[$i])) {
                return false;
            }
        }
        return true;
    }

    public static function is_numeric(string $str): bool
    {
        return is_numeric($str);
    }

    public static function areNotEmpty(array $data): bool
    {
        if (!empty($data)) {
            foreach ($data as $value) {
                if (self::isEmpty($value)) {
                    return false;
                }
            }
        }
        return true;
    }

    public static function unicodeToChinese(string $unicodeStr):string
    {
        $chinesStr =  json_decode('"' . $unicodeStr . '"');
        if (JSON_ERROR_NONE !== json_last_error()) {
            return "";
        }
        return $chinesStr;
    }
    public static function stripNonValidXMLCharacters(string $input):string
    {
        if (empty($input)) {
            return "";
        }
         return preg_replace('/[\\x00-\\x08\\x0b-\\x0c\\x0e-\\x1f]/', '', $input);
    }
}
