<?php

namespace Kubinyete\KnightShieldSdk\Shared\Util;

abstract class ArrayUtil
{
    public const SEPARATOR = '.';

    public static function get(string $path, array $array, $default = null)
    {
        $splitPath = explode(self::SEPARATOR, $path);

        while (is_array($array) && ($key = array_shift($splitPath))) {
            if (array_key_exists($key, $array)) {
                $array = &$array[$key];
            } else {
                $array = null;
            }
        }

        return is_null($array) || !empty($splitPath) ? $default : $array;
    }
}
