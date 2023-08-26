<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Http\Response;
use Closure;

class Api{

    /**
     * @param Request $request
     * @param Closure
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        $request->getRouter()->setContentType('application/json');
        
        return $next($request);
    }
}