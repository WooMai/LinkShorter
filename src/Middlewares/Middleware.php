<?php


namespace App\Middlewares;


use Slim\Http\Request;
use Slim\Http\Response;

interface Middleware
{
    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $next): Response;
}