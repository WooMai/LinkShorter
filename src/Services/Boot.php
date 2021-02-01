<?php

namespace App\Services;


use Illuminate\Database\Capsule\Manager as CapsuleManager;
use Slim\App;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;


class Boot
{
    public static function web()
    {
        ini_set('expose_php', 'Off');

        if (!defined('DEBUG')) {
            define('DEBUG', Config::get('debug'));
        }

        date_default_timezone_set(Config::get('default_timezone') ?? 'UTC');

        Boot::database();

        $container = new Container(array(
            'settings' => array(
                'debug' => DEBUG,
                'displayErrorDetails' => DEBUG
            )
        ));

        $container['notFoundHandler'] = function ($c) {
            return function (Request $request, Response $response) use ($c) {
                return $response->write('Not Found')->withHeader('Cache-Control', 'max-age=60')->withStatus(404);
            };
        };

        $container['notAllowedHandler'] = function ($c) {
            return function (Request $request, Response $response) use ($c) {
                return $response->write('Not Found')->withHeader('Cache-Control', 'max-age=60')->withStatus(404);
            };
        };;

        $app = new App($container);

        require BASE_PATH . '/routes/web.php';

        $app->run();
    }

    public static function database()
    {
        $capsule = new CapsuleManager;
        $mysql = Config::get('mysql');

        if ($mysql['connect_type'] == 'network') {
            $capsule->addConnection(array(
                'driver' => 'mysql',
                'host' => $mysql['host'],
                'port' => $mysql['port'],
                'database' => $mysql['name'],
                'username' => $mysql['user'],
                'password' => $mysql['pass'],
                'prefix' => $mysql['prefix'],
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci'
            ));
        } else {
            $capsule->addConnection(array(
                'driver' => 'mysql',
                'unix_socket' => $mysql['socket'],
                'database' => $mysql['name'],
                'username' => $mysql['user'],
                'password' => $mysql['pass'],
                'prefix' => $mysql['prefix'],
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci'
            ));
        }

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
