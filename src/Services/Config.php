<?php


namespace App\Services;


class Config
{
    public function __construct()
    {
        foreach (SYSTEM_CONFIG as $k => $v) {
            $this->$k = $v;
        }
    }

    /**
     * 读取系统配置
     * @param string $key
     * @return mixed
     */
    public static function get(string $key): mixed
    {
        if (isset(SYSTEM_CONFIG[$key])) {
            return SYSTEM_CONFIG[$key];
        } else {
            return null;
        }
    }

    /**
     * 获取应用版本号
     * @return string|null
     */
    public static function getVersion(): ?string
    {
        $json = json_decode(file_get_contents(BASE_PATH . '/composer.json'));
        return $json->version ?? null;
    }
}