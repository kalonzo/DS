<?php

namespace App\Http\Middleware;

use Closure;

class StoreUserInfo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $typeEts = Request::get('user_selection_type_ets');
        if(!empty($typeEts)){
            \App\Http\Controllers\SessionController::getInstance()->setUserTypeEts($typeEts);
        }
        return $next($request);
    }
}
