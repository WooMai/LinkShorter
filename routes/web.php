<?php

/** @var Slim\App $app */

use App\Controllers\CreateController;
use App\Controllers\RedirectController;
use App\Middlewares\ApiAuth;

$app->group('/api', function ($app) {
    $app->post('/create', CreateController::class);
})->add(new ApiAuth());

$app->get('/{token}', RedirectController::class);


