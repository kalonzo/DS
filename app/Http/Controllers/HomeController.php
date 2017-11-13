<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\BusinessCategory;
use App\Models\Establishment;
use App\Models\EstablishmentBusinessCategory;
use App\Models\Promotion;
use App\Models\Utilities\LatLng;
use App\Utilities\DbQueryTools;
use App\Utilities\StringTools;
use App\Utilities\UuidTools;
use Illuminate\Support\Facades\DB;
use View;

class HomeController extends Controller {

    public static function index() {
        $etsUuids = array();
        $sliderEts = array();
        $defaultGeoloc = false;
        
        $distance = SearchController::DEFAULT_DISTANCE_KM_SEARCH;
        $userLat = SessionController::getInstance()->getUserLat();
        $userLng = SessionController::getInstance()->getUserLng();
        $typeEts = SessionController::getInstance()->getUserTypeEts();
        $userLatLng = new LatLng($userLat, $userLng);
        if (!$userLatLng->isValid()) {
            $userLatLng = GeolocationController::getRawInitialGeolocation();
        }
        
        $attempt = 1;
        $nbResults = 0;
        do{
            $ignoreStep = false;
            switch($attempt){
                case 2:
                    $distance = 20;
                    break;
                case 3:
                    $distance = 50;
                    break;
                case 4:
                    if($defaultGeoloc || $nbResults === 0){
                        $distance = SearchController::DEFAULT_DISTANCE_KM_SEARCH;
                        $userLatLng = GeolocationController::getRawInitialGeolocation();
                        $defaultGeoloc = true;
                    } else {
                        $ignoreStep = true;
                    }
                    break;
            }
            $sliderEtsQuery = Establishment::select([
                                    Establishment::TABLENAME . '.*', DB::raw(DbQueryTools::genRawSqlForGettingUuid('id', \App\Models\Establishment::TABLENAME))
                            ])
                    ->join(\App\Models\EstablishmentMedia::TABLENAME, \App\Models\EstablishmentMedia::TABLENAME . '.id_establishment', '=', Establishment::TABLENAME . '.id')
                    ->where('id_business_type', '=', $typeEts)
                    ->where(Establishment::TABLENAME . '.status', '=', Establishment::STATUS_ACTIVE)
                    ->where(Establishment::TABLENAME . '.business_status', '>=', 50)
                    ->where(\App\Models\EstablishmentMedia::TABLENAME . '.type_use', '=', \App\Models\EstablishmentMedia::TYPE_USE_ETS_HOME_PICS)
                    ->groupBy(Establishment::TABLENAME . '.id')
                    ;
            $geolocLimitSuccess = DbQueryTools::setGeolocLimits($sliderEtsQuery, $userLatLng, $distance, Establishment::TABLENAME);
            $nbResults = $sliderEtsQuery->limit(10)->count();
            if ($ignoreStep || ($geolocLimitSuccess && $nbResults >= 10)) {
                $sliderEts = $sliderEtsQuery->get();
            }
            if($ignoreStep){
                break;
            }
            $attempt++;
        } while($nbResults < 10 && $attempt < 5);
        
        if(!empty($sliderEts)){
            $etsUuids = array_merge($etsUuids, $sliderEts->pluck('uuid')->all());
        }
        
        $dsSelectionEstablishments = array();
        $promotionEstablishments = array();
        $establishmentsQuery = DB::table(Establishment::TABLENAME)
                ->select([
                        Establishment::TABLENAME . '.id as id_establishment'
                        , Establishment::TABLENAME . '.*', Address::TABLENAME . '.*'
                        , 'logo.local_path as logo_path', 'thumbnail.local_path as thumbnail_path'
                        , DB::raw(DbQueryTools::genRawSqlForDistanceCalculation($userLatLng, Establishment::TABLENAME))
                    ])
                ->join(Address::TABLENAME, Address::TABLENAME . '.id', '=', Establishment::TABLENAME . '.id_address')
                ->leftJoin(\App\Models\EstablishmentMedia::TABLENAME.' AS logo', function ($join) {
                        $join->on('logo.id', '=', Establishment::TABLENAME . '.id_logo')
                             ->where('logo.status', '=', \App\Models\EstablishmentMedia::STATUS_VALIDATED);
                    })
                ->leftJoin(\App\Models\EstablishmentMedia::TABLENAME.' AS thumbnail', function ($join) {
                        $join->on('thumbnail.id', '=', Establishment::TABLENAME . '.id_thumbnail')
                             ->where('thumbnail.status', '=', \App\Models\EstablishmentMedia::STATUS_VALIDATED);
                    })
                ->where(Establishment::TABLENAME . '.id_business_type', '=', $typeEts)
                ->where(Establishment::TABLENAME . '.status', '=', Establishment::STATUS_ACTIVE)
                ->where(Establishment::TABLENAME . '.business_status', '>=', 50)
        ;
        $establishmentsQueryWithoutDistance = clone $establishmentsQuery;
        
        $geolocLimitSuccess = DbQueryTools::setGeolocLimits($establishmentsQuery, $userLatLng, $distance, Establishment::TABLENAME);
        if ($geolocLimitSuccess) {
            /************* DS Selection build *********************************/
            $dsSelectionData = with(clone $establishmentsQuery)->where(Establishment::TABLENAME . '.business_status', '>=', 100)->limit(24)->get();
            $dsSelectionEstablishments = EstablishmentController::buildThumbnailData($dsSelectionData, ($distance * 1000));
            foreach($dsSelectionEstablishments as $uuid => $dsSelectionEstablishment){
                $etsUuids[$uuid] = $uuid;
            }
            
            /********** Promotions build **************************************/
            $promotionsData = array();
            $distance = SearchController::DEFAULT_DISTANCE_KM_SEARCH;
            $attempt = 1;
            $nbResults = 0;
            do{
                $ignoreStep = false;
                switch($attempt){
                    case 2:
                        $distance = 20;
                        break;
                    case 3:
                        $distance = 50;
                        break;
                    case 4:
                        if($defaultGeoloc || $nbResults === 0){
                            $distance = SearchController::DEFAULT_DISTANCE_KM_SEARCH;
                            $userLatLng = GeolocationController::getRawInitialGeolocation();
                            $defaultGeoloc = true;
                        } else {
                            $ignoreStep = true;
                        }
                        break;
                    case 5:
                        if($defaultGeoloc || $nbResults === 0){
                            $distance = 20;
                            $userLatLng = GeolocationController::getRawInitialGeolocation();
                            $defaultGeoloc = true;
                        } else {
                            $ignoreStep = true;
                        }
                        break;
                }
                $promotionsQuery =  with(clone $establishmentsQueryWithoutDistance)
                                    ->addSelect(Promotion::TABLENAME.'.name as promo_name')
                                    ->join(Promotion::TABLENAME, Establishment::TABLENAME . '.id', '=', Promotion::TABLENAME . '.id_establishment')
                                    ->whereRaw(Promotion::TABLENAME . '.end_date > NOW()')
                                    ;
                $geolocLimitSuccess = DbQueryTools::setGeolocLimits($promotionsQuery, $userLatLng, $distance, Establishment::TABLENAME);
                $nbResults = $promotionsQuery->limit(24)->count();

                if ($ignoreStep || ($geolocLimitSuccess && $nbResults >= 6)) {
                    $promotionsData = $promotionsQuery->get();
                }
                if($ignoreStep){
                    break;
                }
                $attempt++;
            } while($nbResults < 6 && $attempt <= 5);
            
            if(!empty($promotionsData)){
                $promotionEstablishments = EstablishmentController::buildThumbnailData($promotionsData, ($distance * 1000));
                foreach($promotionEstablishments as $uuid => $promotionEstablishment){
                    $etsUuids[$uuid] = $uuid;
                }
            }
                
            /********** Weekly most visited ***********************************/
            $mostVisitedData =  with(clone $establishmentsQuery)
                                ->orderBy(Establishment::TABLENAME . '.nb_last_week_visits', 'DESC')
                                ->limit(24)->get();
            $mostVisitedEstablishments = EstablishmentController::buildThumbnailData($mostVisitedData, ($distance * 1000));
            foreach($mostVisitedEstablishments as $uuid => $mostVisitedEstablishment){
                $etsUuids[$uuid] = $uuid;
            }
        }
        
        switch($typeEts){
            case \App\Models\BusinessType::TYPE_BUSINESS_RESTAURANT:
                // Link cooking type to establishment thumbnails
                $businessCategories = BusinessCategory::select([
                        BusinessCategory::TABLENAME . '.name', EstablishmentBusinessCategory::TABLENAME . '.id_establishment',
                        DB::raw(DbQueryTools::genRawSqlForGettingUuid('id_establishment', EstablishmentBusinessCategory::TABLENAME))
                    ])
                    ->join(EstablishmentBusinessCategory::TABLENAME, BusinessCategory::TABLENAME . '.id', '=', EstablishmentBusinessCategory::TABLENAME . '.id_business_category')
                    ->whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('id_establishment', $etsUuids, EstablishmentBusinessCategory::TABLENAME))
                    ->orderBy(EstablishmentBusinessCategory::TABLENAME.'.created_at')
                    ->get();
                
                foreach($businessCategories as $etsCategoryData){
                    $idEstablishment = $etsCategoryData->id_establishment;
                    $uuidEstablishment = $etsCategoryData->uuid;
                    if(!empty($sliderEts)){
                        foreach($sliderEts as $establishment){
                            if($establishment->getId() === $idEstablishment && !isset($establishment->cooking_type)){
                                $establishment->cooking_type = $etsCategoryData->name;
                            }
                        }
                    }
                    if(!empty($dsSelectionEstablishments)){
                        if(isset($dsSelectionEstablishments[$uuidEstablishment]) && !isset($dsSelectionEstablishments[$uuidEstablishment]['biz_category_1'])){
                            $dsSelectionEstablishments[$uuidEstablishment]['biz_category_1'] = $etsCategoryData->name;
                        }
                    }
                    if(!empty($promotionEstablishments)){
                        if(isset($promotionEstablishments[$uuidEstablishment]) && !isset($promotionEstablishments[$uuidEstablishment]['biz_category_1'])){
                            $promotionEstablishments[$uuidEstablishment]['biz_category_1'] = $etsCategoryData->name;
                        }
                    }
                    if(!empty($mostVisitedEstablishments)){
                        if(isset($mostVisitedEstablishments[$uuidEstablishment]) && !isset($mostVisitedEstablishments[$uuidEstablishment]['biz_category_1'])){
                            $mostVisitedEstablishments[$uuidEstablishment]['biz_category_1'] = $etsCategoryData->name;
                        }
                    }
                }
                break;
        }
        list($dsSelectionEstablishments, $promotionEstablishments, $mostVisitedEstablishments) = EstablishmentController::buildExtraThumbnailData(
                array($dsSelectionEstablishments, $promotionEstablishments, $mostVisitedEstablishments), $etsUuids);
        
        $view = View::make('front.home')
                    ->with('slider_ets', $sliderEts)
                    ->with('ds_selection', $dsSelectionEstablishments)
                    ->with('promotions', $promotionEstablishments)
                    ->with('most_visited', $mostVisitedEstablishments)
                    ->with('reloaded', \Illuminate\Support\Facades\Request::get('reload'));
        $response = \Illuminate\Support\Facades\Response::make($view);
        if (!empty(\Illuminate\Support\Facades\Cookie::queued('userLng'))) {
            $response->withCookie(\Illuminate\Support\Facades\Cookie::queued('userLng'));
        }
        return $response;
    }

}
