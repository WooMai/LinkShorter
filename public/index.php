<?php

use App\Services\Boot;

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/vendor/autoload.php';
require BASE_PATH . '/config/config.php';

Boot::web();