<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\BusinessCategory;
use App\Models\Establishment;
use App\Models\EstablishmentBusinessCategory;
use App\Models\Promotion;
use App\Models\Restaurant;
use App\Models\Utilities\LatLng;
use App\Utilities\DbQueryTools;
use App\Utilities\StringTools;
use App\Utilities\UuidTools;
use Illuminate\Support\Facades\DB;
use View;

class HomeController extends Controller {

    public static function index() {
        $distance = SearchController::DEFAULT_DISTANCE_KM_SEARCH;
        $sliderEts = array();
        $userLat = SessionController::getInstance()->getUserLat();
        $userLng = SessionController::getInstance()->getUserLng();
        $typeEts = SessionController::getInstance()->getUserTypeEts();
        $userLatLng = new LatLng($userLat, $userLng);
        if (!$userLatLng->isValid()) {
            $userLatLng = GeolocationController::getRawInitialGeolocation();
        }
        $sliderEtsQuery = Restaurant::where('id_business_type', '=', $typeEts)
        ;
        $geolocLimitSuccess = DbQueryTools::setGeolocLimits($sliderEtsQuery, $userLatLng, $distance, Establishment::TABLENAME);
        if ($geolocLimitSuccess) {
            $sliderEts = $sliderEtsQuery->get();
        }

        $establishments = array();
        $establishmentsQuery = DB::table(Establishment::TABLENAME)
                ->select(DB::raw(Establishment::TABLENAME . '.*, ' . Address::TABLENAME . '.* '
                                . ', biz_category1.id as id_biz_category_1, biz_category1.name as name_biz_category_1'
                                . ',' . DbQueryTools::genRawSqlForDistanceCalculation($userLatLng, Establishment::TABLENAME)))
                ->join(Address::TABLENAME, Address::TABLENAME . '.id', '=', Establishment::TABLENAME . '.id_address')
                ->join(EstablishmentBusinessCategory::TABLENAME, Establishment::TABLENAME . '.id', '=', EstablishmentBusinessCategory::TABLENAME . '.id_establishment')
                ->join(BusinessCategory::TABLENAME . ' AS biz_category1', 'biz_category1.id', '=', EstablishmentBusinessCategory::TABLENAME . '.id_business_category')
                ->leftJoin(Promotion::TABLENAME, Establishment::TABLENAME . '.id', '=', Promotion::TABLENAME . '.id_establishment')
                ->where(Establishment::TABLENAME . '.id_business_type', '=', $typeEts)
        ;
        $geolocLimitSuccess = DbQueryTools::setGeolocLimits($establishmentsQuery, $userLatLng, $distance, Establishment::TABLENAME);
        if ($geolocLimitSuccess) {
//            $establishmentsQuery->offset($sliceStart)->limit($nbElementPerPage);
            $establishmentsData = $establishmentsQuery->get();
            foreach ($establishmentsData as $establishmentData) {
                if ($establishmentData->rawDistance <= ($distance * 1000)) {
                    $uuid = UuidTools::getUuid($establishmentData->id);
                    // Search results list
                    $establishments[$uuid]['id'] = $uuid;
                    $establishments[$uuid]['name'] = $establishmentData->name;
                    $establishments[$uuid]['img'] = "/img/images_ds/imagen-DS-" . rand(1, 20) . ".jpg";
                    $establishments[$uuid]['city'] = $establishmentData->city;
                    $establishments[$uuid]['country'] = \App\Models\Country::getCountryLabel($establishmentData->id_country);
                    $establishments[$uuid]['biz_category_1'] = $establishmentData->name_biz_category_1;
                    $establishments[$uuid]['raw_distance'] = StringTools::displayCleanDistance($establishmentData->rawDistance);
                    $establishments[$uuid]['latitude'] = $establishmentData->latitude;
                    $establishments[$uuid]['longitude'] = $establishmentData->longitude;
                    $establishments[$uuid]['url'] = Establishment::getUrlStatic($establishmentData->id_business_type, $establishmentData->city, 
                            $establishmentData->slug, $establishmentData->url_id);
                }
            }
        }

        $view = View::make('front.home')->with('slider_ets', $sliderEts)->with('ds_selection', $establishments)
                ->with('reloaded', \Illuminate\Support\Facades\Request::get('reload'));
        $response = \Illuminate\Support\Facades\Response::make($view);
        if (!empty(\Illuminate\Support\Facades\Cookie::queued('userLng'))) {
            $response->withCookie(\Illuminate\Support\Facades\Cookie::queued('userLng'));
        }
        return $response;
    }

}
