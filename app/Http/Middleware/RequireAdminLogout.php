<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Session\Auth\Login;
use Closure;

class RequireAdminLogout{

    /**
     * @param Request $request
     * @param Closure
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        if(Login::isLogged()){
            $request->getRouter()->redirect('/home');
        }

        return $next($request);
    }
}