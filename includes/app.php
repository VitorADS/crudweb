<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Http\Middleware\Api;
use App\Http\Middleware\JWTAuth;
use App\Http\Middleware\Maintenance;
use App\Utils\View;
use WilliamCosta\DotEnv\Environment;
use App\Http\Middleware\Queue as MiddlewareQueue;
use App\Http\Middleware\RequireAdminLogin;
use App\Http\Middleware\RequireAdminLogout;
use App\Http\Middleware\UserBasicAuth;

Environment::load(__DIR__ . '/../');

define('URL', getenv('URL'));

View::init([
	'URL' => URL
]);

MiddlewareQueue::setMap([
    'maintenance' => Maintenance::class,
    'required-admin-logout' => RequireAdminLogout::class,
    'required-admin-login' => RequireAdminLogin::class,
    'api' => Api::class,
    'user-basic-auth' => UserBasicAuth::class,
    'jwt-auth' => JWTAuth::class
]);

MiddlewareQueue::setDefault([
    'maintenance'
]);