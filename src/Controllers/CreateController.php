<?php


namespace App\Controllers;


use App\Models\Redirect;
use App\Services\Config;
use App\Services\Redis;
use App\Utils\Random;
use Slim\Http\Request;
use Slim\Http\Response;

class CreateController
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $target = $request->getParsedBodyParam('target');
        $user = $request->getAttribute('user');

        if (filter_var($target, FILTER_VALIDATE_URL) !== $target) {
            return $response->withJson(array(
                'ok' => false,
                'msg' => 'Invalid URL'
            ));
        }

        $purl = parse_url($target);
        if (!in_array($purl['scheme'], ['http', 'https', 'tg'])) {
            return $response->withJson(array(
                'ok' => false,
                'msg' => 'Invalid URL'
            ));
        }

        $redir = Redirect::whereRaw('BINARY target = ?', [$target])->first();
        if ($redir == null) {
            $count = Redirect::count();
            $length = strlen($count) - 1;
            if ($length < 3) {
                $length = 3;
            }

            try {
                $i = 0;
                do {
                    $i++;
                    if ($i > 10) {
                        throw new \Exception();
                    }
                    $token = Random::str($length);
                } while (Redirect::where('token', $token)->exists());

                $short_url_length = mb_strlen(Config::get('root_url') ) + 1 + $length;
                if (mb_strlen($target) <= $short_url_length) {
                    return $response->withJson(array(
                        'ok' => false,
                        'msg' => 'The target URL is not longer than the shortened URL.'
                    ));
                }

                $redir = new Redirect();
                $redir->token = $token;
                $redir->user_id = $user->id;
                $redir->target = $target;
                $redir->manage_token = Random::str(32);
                $redir->create_time = time();
                $redir->save();
            } catch (\Exception) {
                return $response->withJson(array(
                    'ok' => false,
                    'msg' => 'Internal Error'
                ));
            }

            $redis = Redis::client();
            $redis->set('token:' . $token, $target);
        }

        return $response->withJson(array(
            'ok' => true,
            'data' => $redir->toArray()
        ));
    }
}