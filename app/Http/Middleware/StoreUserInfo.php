<?php

namespace App\Http\Middleware;

use App\Http\Controllers\GeolocationController;
use App\Http\Controllers\SessionController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request as Request2;

class StoreUserInfo
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        // Geolocation
        $userLat = Request2::get('userLat');
        $userLng = Request2::get('userLng');
        if(!empty($userLat) && !empty($userLng)){
            SessionController::getInstance()->setUserLng($userLng);
            SessionController::getInstance()->setUserLat($userLat);
            Cookie::queue(cookie('userLat', $userLat, 60*12, null, null, null, false));
            Cookie::queue(cookie('userLng', $userLng, 60*12, null, null, null, false));
        }
        // No geolocation available
        if(empty(SessionController::getInstance()->getUserLat()) || empty(SessionController::getInstance()->getUserLng())){
            $userDefaultLatLng = GeolocationController::getRawInitialGeolocation();
            if(!empty($userDefaultLatLng)){
//                SessionController::getInstance()->setUserLat($userDefaultLatLng->getLat());
//                SessionController::getInstance()->setUserLng($userDefaultLatLng->getLng());
//                Cookie::queue(cookie('userLat', $userDefaultLatLng->getLat(), 60*12, null, null, null, false));
//                Cookie::queue(cookie('userLng', $userDefaultLatLng->getLng(), 60*12, null, null, null, false));
            }
        }
        // Type establishment
        $typeEts = Request2::get('user_selection_type_ets');
        if(!empty($typeEts)){
            SessionController::getInstance()->setUserTypeEts($typeEts);
        }
        return $next($request);
    }
}
