<?php

namespace App\Controllers;

use App\Services\Redis;
use Slim\Http\Request;
use Slim\Http\Response;

class RedirectController
{
    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $redis = Redis::client();

        $url = $redis->get('token:' . $args['token']);
        if ($url) {
            return $response->withRedirect($url, 301)->withHeader('Cache-Control', 'public, max-age=31536000');
        } else {
            return $response->withHeader('Cache-Control', 'max-age=60')->withStatus(404)->write('Not Found');
        }
    }
}