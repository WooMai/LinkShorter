<?php


namespace App\Middlewares;


use App\Models\User;
use Slim\Http\Request;
use Slim\Http\Response;

class ApiAuth implements Middleware
{

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $next): Response
    {
        $api_token = $request->getHeader('API-Token')[0] ?? null;

        $user = User::where('api_token', $api_token)->first();
        if (!$user) {
            return $response->withJson(array(
                'ok' => false,
                'msg' => 'Bad Token'
            ));
        }

        $request = $request->withAttribute('user', $user);

        return $next($request, $response);
    }
}