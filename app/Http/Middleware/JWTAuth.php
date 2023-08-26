<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Http\Response;
use App\Models\Entitys\User;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuth{

    /**
     * @param Request $request
     * @return mixed
     */
    private function getJWTAuthUser(Request $request): mixed
    {
        $headers = $request->getHeaders();
        $jwt = isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : '';

        try{
            $decode = (array) JWT::decode($jwt, new Key(getenv('JWT_KEY'), 'HS256'));
        }catch(\Exception $e){
            throw new \Exception("Token invalido", 403);
        }
        
        $email = $decode['email'] ?? '';
        $user = User::getUserByEmail($email);

        return $user instanceof User ? $user : false;
    }

    /**
     * @param Request $request
     */
    private function auth(Request $request)
    {
        if($user = $this->getJWTAuthUser($request)){
            $request->user = $user;
            return true;
        }

        throw new \Exception('Acesso negado', 403);
    }

    /**
     * @param Request $request
     * @param Closure
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        $this->auth($request);
        
        return $next($request);
    }
}