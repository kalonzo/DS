<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Utilities\UuidTools;
use Closure;
use Illuminate\Support\Facades\Route;

class ImplicitBinding
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $route = Route::current();
        if(!is_null($route)){
            $routeParams = $route->parameters();
            foreach($routeParams as $paramKey => $paramValue){
                if(checkHexUuid($paramValue)){
                    Route::current()->parameters[$paramKey] = UuidTools::getId($paramValue);
                }
            }
        }
        return $next($request);
    }
}
