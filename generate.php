<?php

use App\Models\Redirect;
use App\Services\Boot;
use App\Services\Redis;

const BASE_PATH = __DIR__;

require BASE_PATH . '/vendor/autoload.php';
require BASE_PATH . '/config/config.php';

Boot::database();

$redis = Redis::client();

$redirects = Redirect::all();

foreach ($redirects as $redirect) {
    $redis->set("token:$redirect->token", $redirect->target);
}

echo "{$redirects->count()} Redirects generated.";
