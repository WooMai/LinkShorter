<?php

namespace App\Utils;

use RandomLib\Factory;

class Random
{
    /**
     * 生成随机十六进制字符串
     * @param int $len
     * @return string
     * @throws RuntimeException
     */
    public static function hex(int $len = 16): string
    {
        $factory = new Factory;
        $generator = $factory->getMediumStrengthGenerator();
        $binlen = ceil($len / 2);
        $r = bin2hex($generator->generate($binlen));
        return substr($r, 0, $len);
    }

    /**
     * 生成随机字符串
     * @param int $len
     * @return string
     * @throws RuntimeException
     */
    public static function str(int $len = 16): string
    {
        $list = str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');

        $factory = new Factory;
        $generator = $factory->getMediumStrengthGenerator();
        return $generator->generateString($len, $list);
    }

    /**
     * 生成随机整数
     * @param int $min
     * @param int $max
     * @return int
     * @throws RuntimeException
     * @throws RangeException
     */
    public static function int(int $min, int $max): int
    {
        $factory = new Factory;
        $generator = $factory->getMediumStrengthGenerator();
        return $generator->generateInt($min, $max);
    }

    /**
     * 返回数组中一个随机元素
     * @param array $array
     * @return mixed
     * @throws RuntimeException
     * @throws RangeException
     */
    public static function array(array $array): mixed
    {
        if (count($array) < 1) {
            return null;
        }

        sort($array);
        $index = Random::int(0, (count($array) - 1));
        return $array[$index];
    }
}