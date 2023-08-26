<?php

namespace App\routes\auth;

use App\Controllers\AnnotationsController;
use App\Http\Response;
use App\Models\Service\AnnotationService;
use App\Models\Service\UserService;

$router->get('/home', [
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, AnnotationsController::getHome($request, new UserService()));
    }
]);

$router->post('/home', [
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, AnnotationsController::saveAction($request, new UserService()));
    }
]);

$router->get('/remove', [
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, AnnotationsController::removeAction($request, new AnnotationService()));
    }
]);

$router->get('/annotation', [
    'middlewares' => [
        'required-admin-login',
        'api'
    ],
    function($request){
        return new Response(200, AnnotationsController::getAnnotation($request, new AnnotationService()), 'application/json');
    }
]);