<?php

namespace App\routes\auth;

use App\Controllers\AuthController;
use App\Http\Response;
use App\Models\Service\UserService;

$router->get('/', [
    'middlewares' => [
        'required-admin-logout'
    ],
    function($request){
        return new Response(200, AuthController::login($request));
    }
]);

$router->post('/', [
    'middlewares' => [
        'required-admin-logout'
    ],
    function($request){
        return new Response(200, AuthController::loginAction($request, new UserService()));
    }
]);

$router->get('/register', [
    'middlewares' => [
        'required-admin-logout'
    ],
    function($request){
        return new Response(200, AuthController::register($request));
    }
]);

$router->post('/register', [
    'middlewares' => [
        'required-admin-logout'
    ],
    function($request){
        return new Response(200, AuthController::registerAction($request, new UserService()));
    }
]);

$router->get('/logout', [
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, AuthController::logout($request, new UserService()));
    }
]);