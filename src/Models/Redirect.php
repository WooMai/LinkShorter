<?php


namespace App\Models;


use App\Services\Config;

class Redirect extends Model
{
    protected $table = 'redirects';
    protected $visible = ['token', 'target', 'manage_token', 'shorten_url'];
    protected $appends = ['shorten_url'];

    /**
     * @return string
     */
    public function getShortenUrlAttribute(): string
    {
        return Config::get('root_url') .  '/' . $this->attributes['token'];
    }
}