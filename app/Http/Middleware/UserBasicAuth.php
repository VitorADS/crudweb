<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Http\Response;
use App\Models\Entitys\User;
use Closure;

class UserBasicAuth{

    /**
     * @return mixed
     */
    private function getBasicAuthUser(): mixed
    {
        if(!isset($_SERVER['PHP_AUTH_USER']) or !isset($_SERVER['PHP_AUTH_PW'])){
            return false;
        }

        $user = User::getUserByEmail($_SERVER['PHP_AUTH_USER']);
        if(!$user instanceof User){
            return false;
        }

        return password_verify($_SERVER['PHP_AUTH_PW'], $user->getSenha()) ? $user : false;
    }

    /**
     * @param Request $request
     */
    private function basicAuth(Request $request)
    {
        if($user = $this->getBasicAuthUser()){
            $request->user = $user;
            return true;
        }

        throw new \Exception('Usuario ou senha invalidos', 403);
    }

    /**
     * @param Request $request
     * @param Closure
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        $this->basicAuth($request);
        
        return $next($request);
    }
}