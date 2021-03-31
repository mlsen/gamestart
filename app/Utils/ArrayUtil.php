<?php


namespace App\Utils;


class ArrayUtil
{
    public static function toSeparatedString(array $arr, string $key, string $separator): string
    {
        $length = count($arr);
        $str = '';

        for ($i = 0; $i < $length; $i++) {
            if (!array_key_exists($key, $arr[$i])) {
                continue;
            }

            $str .= $arr[$i][$key];

            if ($i < $length - 1) {
                $str .= $separator;
            }
        }

        return $str;
    }
}
