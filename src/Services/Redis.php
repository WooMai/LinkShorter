<?php


namespace App\Services;


use RedisException;

class Redis
{
    /**
     * @return \Redis
     */
    public static function client(): \Redis
    {
        $redis_config = Config::get('redis');

        if (!empty($GLOBALS['redis'])) {
            $redis = $GLOBALS['redis'];
            try {
                $redis->select($redis_config['default_db']);
            } catch (RedisException $e) {
                goto Connect;
            }
        } else {
            Connect:  // 初始化连接
            $redis = new \Redis;

            if ($redis_config['connect_type'] == 'socket') {
                $redis->connect($redis_config['socket'], 0);
            } else {
                $redis->connect($redis_config['host'], $redis_config['port']);
            }

            if (!empty($redis_config['passwd'])) {
                $redis->auth($redis_config['passwd']);
            }
            $redis->select($redis_config['default_db']);
            $GLOBALS['redis'] = $redis;
        }

        return $redis;
    }
}