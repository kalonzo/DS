<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\BusinessCategory;
use App\Models\Establishment;
use App\Models\EstablishmentBusinessCategory;
use App\Models\Restaurant;
use App\Models\Utilities\LatLng;
use App\Utilities\GeolocTools;
use App\Utilities\UuidTools;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use View;

/**
 * Description of SearchController
 *
 * @author Nico
 */
class SearchController {
    const NB_QUICK_RESULTS_PER_TYPE = 5;
    
    const QUICK_SEARCH_SECTION_DISTANCE = 1;
    const QUICK_SEARCH_SECTION_NAME = 2;
    const QUICK_SEARCH_SECTION_COOKING_TYPE = 3;
    
    const SEARCH_ORDER_BY_PROXIMITY = 1;
    const SEARCH_ORDER_BY_NAME = 2;
    
    public static function quickSearch($terms){
        $results = array();
        $userLat = SessionController::getInstance()->getUserLat();
        $userLng = SessionController::getInstance()->getUserLng();
        $typeEts = SessionController::getInstance()->getUserTypeEts();
        $userLatLng = new LatLng($userLat, $userLng);

        if(!empty($terms) && $userLatLng->isValid()){
            // Search by proximity
            $squareCoordinates = GeolocTools::getSquareCoordinates($userLatLng);
            
            $minLat = 0.0;
            $minLng = 0.0;
            $maxLat = 0.0;
            $maxLng = 0.0;
            foreach($squareCoordinates as $squareCoordinate){
                if($minLat == 0 || $squareCoordinate->getLat() < $minLat){
                    $minLat = $squareCoordinate->getLat();
                }
                if($minLng == 0 || $squareCoordinate->getLng() < $minLng){
                    $minLng = $squareCoordinate->getLng();
                }
                if($maxLat == 0 || $squareCoordinate->getLat() > $maxLat){
                    $maxLat = $squareCoordinate->getLat();
                }
                if($maxLng == 0 || $squareCoordinate->getLng() > $maxLng){
                    $maxLng = $squareCoordinate->getLng();
                }
            }
            if(!empty($minLat) && !empty($maxLat) && !empty($minLng) && !empty($maxLng)){
                $rawDistanceRestaurantsQuery = Restaurant::where('name', 'LIKE', "%$terms%")
//                                        ->where('id_business_type', '=', $typeEts)
//                                        ->whereBetween('latitude', array($minLat, $maxLat))
//                                        ->whereBetween('longitude', array($minLng, $maxLng))
                                        ;
                $rawDistanceList = array();
                $rawDistanceRestaurants = $rawDistanceRestaurantsQuery->get();
                foreach($rawDistanceRestaurants as $rawDistanceRestaurant){
                    $rawDistance = GeolocTools::calculateRawDistance($userLatLng, $rawDistanceRestaurant->getLatLng());
                    $rawDistanceList[$rawDistance] = $rawDistanceRestaurant;
                }
                ksort($rawDistanceList);
                $counter = 1;
                foreach($rawDistanceList as $distance => $restaurant){
                    if($counter <= self::NB_QUICK_RESULTS_PER_TYPE){
                        $results [] = array(
                                'id' => $restaurant->getUuid(),
                                'label' => $restaurant->getName().' ('.($distance / 1000).'km)',
                                'value' => $restaurant->getName(),
                                'section' => 'Localité',
                                'section_id' => self::QUICK_SEARCH_SECTION_DISTANCE,
                                'lat' => $restaurant->getLatitude(),
                                'lng' => $restaurant->getLongitude()
                            );
                        $counter++;
                    } else {
                        break;
                    }
                }
                // Search by alphabetic
                $alphabetRestaurants = $rawDistanceRestaurantsQuery->orderBy('name')->limit(self::NB_QUICK_RESULTS_PER_TYPE)->get();
                foreach($alphabetRestaurants as $distance => $restaurant){
                    $results [] = array(
                            'id' => $restaurant->getUuid(),
                            'label' => $restaurant->getName(),
                            'value' => $restaurant->getName(),
                            'section' => 'Nom',
                            'section_id' => self::QUICK_SEARCH_SECTION_NAME,
                            'lat' => $restaurant->getLatitude(),
                            'lng' => $restaurant->getLongitude()
                        );
                }
                
                // Search by cooking type
                $cookingTypesResults = BusinessCategory::select(DB::raw('count('.EstablishmentBusinessCategory::TABLENAME.'.id_establishment'.') as nb_establishment, '
                                                                        .BusinessCategory::TABLENAME.'.id, '.BusinessCategory::TABLENAME.'.name'))
                    ->join(EstablishmentBusinessCategory::TABLENAME, EstablishmentBusinessCategory::TABLENAME.'.id_business_category', '=', BusinessCategory::TABLENAME.'.id')
                    ->join(Establishment::TABLENAME, EstablishmentBusinessCategory::TABLENAME.'.id_establishment', '=', Establishment::TABLENAME.'.id')
                    ->where(BusinessCategory::TABLENAME.'.name', 'LIKE', "%$terms%")
                    ->where(BusinessCategory::TABLENAME.'.type', '=', BusinessCategory::TYPE_COOKING_TYPE)
                    ->where(Establishment::TABLENAME.'.id_business_type', '=', $typeEts)
                    ->groupBy(BusinessCategory::TABLENAME.'.id')
                    ->orderBy(BusinessCategory::TABLENAME.'.name')
                    ->limit(self::NB_QUICK_RESULTS_PER_TYPE)
                    ->get()
                    ;
                foreach($cookingTypesResults as $result){
                    $results [] = array(
                            'id' => UuidTools::getUuid($result->id_business_category),
                            'label' => $result->name.' ('.$result->nb_establishment.')',
                            'value' => $result->name,
                            'section' => 'Type de cuisine',
                            'section_id' => self::QUICK_SEARCH_SECTION_COOKING_TYPE
                        );
                }
                
            }
        }
        
        return $results;
    }
    
    public static function search(){
        $view = null;
        $establishmentsQuery = self::buildSearchQuery();
        
        if(!empty($establishmentsQuery)){
            $resultsPagination = self::buildSearchResults($establishmentsQuery);
            if(!empty($resultsPagination)){
                $view = View::make('front.search')->with('establishments', $resultsPagination);
            }
        }
        return $view;
    }
    
    public static function searchReload(){
        $view = null;
        $establishmentsQuery = self::buildSearchQuery();
        
        if(!empty($establishmentsQuery)){
            $filterValues = array();
            $resultsPagination = self::buildSearchResults($establishmentsQuery);
            if(!empty($resultsPagination)){
                $view = View::make('components.search_results')->with('establishments', $resultsPagination)->with('filter_values', $filterValues);
            }
        }
        return $view;
    }
    
    /**
     * 
     * @return \Eloquent
     */
    public static function buildSearchQuery(){
        $establishmentsQuery = null;
        $userLat = SessionController::getInstance()->getUserLat();
        $userLng = SessionController::getInstance()->getUserLng();
        $userLatLng = new LatLng($userLat, $userLng);
        
        $terms = Request::get('term');
        $distance = Request::get('distance');
        $typeEts = SessionController::getInstance()->getUserTypeEts();
        
        if($userLatLng->isValid()){
            
            $section = Request::get('section');
            switch($section){

            }
            
            $businessCategoryType = null;
            switch($typeEts){
                case Establishment::TYPE_BUSINESS_RESTAURANT:
                    $businessCategoryType = BusinessCategory::TYPE_COOKING_TYPE;
                    break;
            }
            
            // Search by proximity
            $squareCoordinates = GeolocTools::getSquareCoordinates($userLatLng, $distance);
            
            $minLat = 0.0;
            $minLng = 0.0;
            $maxLat = 0.0;
            $maxLng = 0.0;
            foreach($squareCoordinates as $squareCoordinate){
                if($minLat == 0 || $squareCoordinate->getLat() < $minLat){
                    $minLat = $squareCoordinate->getLat();
                }
                if($minLng == 0 || $squareCoordinate->getLng() < $minLng){
                    $minLng = $squareCoordinate->getLng();
                }
                if($maxLat == 0 || $squareCoordinate->getLat() > $maxLat){
                    $maxLat = $squareCoordinate->getLat();
                }
                if($maxLng == 0 || $squareCoordinate->getLng() > $maxLng){
                    $maxLng = $squareCoordinate->getLng();
                }
            }
            if(!empty($minLat) && !empty($maxLat) && !empty($minLng) && !empty($maxLng)){
                $establishmentsQuery = DB::table(Establishment::TABLENAME)
                            ->select(DB::raw(Establishment::TABLENAME.'.*, '.Address::TABLENAME.'.*, '.BusinessCategory::TABLENAME.'.name as type_category'))
                            ->join(Address::TABLENAME, Address::TABLENAME.'.id', '=', Establishment::TABLENAME.'.id_address')
                            ->join(EstablishmentBusinessCategory::TABLENAME, Establishment::TABLENAME.'.id', '=', EstablishmentBusinessCategory::TABLENAME.'.id_establishment')
                            ->join(BusinessCategory::TABLENAME, BusinessCategory::TABLENAME.'.id', '=', EstablishmentBusinessCategory::TABLENAME.'.id_business_category')
                            ->where(Establishment::TABLENAME.'.name', 'LIKE', "%$terms%")
                            ->where(Establishment::TABLENAME.'.id_business_type', '=', $typeEts)
                            ;
                if(!empty($businessCategoryType)){
                    $establishmentsQuery->where(BusinessCategory::TABLENAME.'.type', '=', $businessCategoryType);
                }
                
                $orderBy = Request::get('order_by');
                switch($orderBy){
                    default :
                    case self::SEARCH_ORDER_BY_PROXIMITY:

                        break;
                    case self::SEARCH_ORDER_BY_NAME:
                        $establishmentsQuery->orderBy('name');
                        break;
                }
            }
        }
        return $establishmentsQuery;
    }
    
    /**
     * 
     * @param type $searchQuery
     * @return LengthAwarePaginator
     */
    public static function buildSearchResults($searchQuery){
        $establishments = array();
        $resultsPagination = null;
        if(!empty($searchQuery)){
            // Query pagination management
            $nbElementPerPage = 10;
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $sliceStart = ($currentPage - 1) * $nbElementPerPage;
            $nbTotalResults = $searchQuery->count();
            $searchQuery->offset($sliceStart)->limit($nbElementPerPage);

            $establishmentsData = $searchQuery->get();
            foreach($establishmentsData as $establishmentData){    
                $uuid = UuidTools::getUuid($establishmentData->id);
                $establishments[$uuid]['id'] = $uuid;
                $establishments[$uuid]['name'] = $establishmentData->name;
                $establishments[$uuid]['img'] = "/img/images_ds/imagen-DS-".rand(1, 20).".jpg";
                $establishments[$uuid]['city'] = $establishmentData->city;
                $establishments[$uuid]['country'] = $establishmentData->country;
                $establishments[$uuid]['type_category'] = $establishmentData->type_category;
            }
            
            // Paginate results
            $resultsPagination = new LengthAwarePaginator($establishments, $nbTotalResults, $nbElementPerPage);
            $resultsPagination->setPath(Request::url());
        }
        return $resultsPagination;
    }
}
