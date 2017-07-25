<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use App\Models\Restaurant;
use App\Models\Utilities\LatLng;
use App\Utilities\DbQueryTools;
use View;

class HomeController extends Controller
{
    public static function index(){
        $sliderEts = array();
        $userLat = SessionController::getInstance()->getUserLat();
        $userLng = SessionController::getInstance()->getUserLng();
        $typeEts = SessionController::getInstance()->getUserTypeEts();
        $userLatLng = new LatLng($userLat, $userLng);
        if(!$userLatLng->isValid()) {
            $userLatLng = GeolocationController::getRawInitialGeolocation();
        }
        $sliderEtsQuery = Restaurant::where('id_business_type', '=', $typeEts)
                            ;
        $geolocLimitSuccess = DbQueryTools::setGeolocLimits($sliderEtsQuery, $userLatLng, SearchController::DEFAULT_DISTANCE_KM_SEARCH, Establishment::TABLENAME);
        if($geolocLimitSuccess){
            $sliderEts = $sliderEtsQuery->get();
        }
        
        return View::make('front.home')->with('slider_ets', $sliderEts);
    }
}
