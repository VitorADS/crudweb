<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Http\Response;
use Closure;
use Exception;

class Maintenance{

    /**
     * @param Request $request
     * @param Closure
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        if(getenv('MAINTENANCE') == 'true'){
            throw new Exception("Pagina em manutencao", 200);
        }
        
        return $next($request);
    }
}