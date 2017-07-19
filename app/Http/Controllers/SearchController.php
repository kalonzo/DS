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
    const DEFAULT_DISTANCE_KM_SEARCH = 5;
    const DEFAULT_DISPLAY_BY = 25;
    
    const QUICK_SEARCH_SECTION_DISTANCE = 1;
    const QUICK_SEARCH_SECTION_NAME = 2;
    const QUICK_SEARCH_SECTION_COOKING_TYPE = 3;
    
    const SEARCH_ORDER_BY_PROXIMITY = 1;
    const SEARCH_ORDER_BY_NAME = 2;
    const SEARCH_ORDER_BY_COOKING_TYPE = 3;
    
    public static $nbElementsPerPageChoices = array(6, 12, 24);
    
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
                                        ->where('id_business_type', '=', $typeEts)
                                        ->whereBetween('latitude', array($minLat, $maxLat))
                                        ->whereBetween('longitude', array($minLng, $maxLng))
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
                                'order_by' => self::SEARCH_ORDER_BY_PROXIMITY,
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
                            'order_by' => self::SEARCH_ORDER_BY_NAME,
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
                            'order_by' => self::SEARCH_ORDER_BY_COOKING_TYPE
                        );
                }
                
            }
        }
        
        return $results;
    }
    
    public static function search(){
        $view = null;
        self::buildFilterLabels();
        $establishmentsQuery = self::buildSearchQuery();
        
        if(!empty($establishmentsQuery)){
            $resultsPagination = self::buildSearchResults($establishmentsQuery);
            $filterValues = SessionController::getInstance()->getSearchFilterValues();
            $filterLabels = \App\Utilities\StorageHelper::getInstance()->get('search.filter_data');
            if(!empty($resultsPagination)){
                $reload = Request::get('reload');
                $viewName = null;
                if($reload){
                    $viewName = 'components.search_results';
                } else {
                    $viewName = 'front.search';
                }
                $view = View::make($viewName)->with('establishments', $resultsPagination)->with('filter_values', $filterValues)
                                                                                        ->with('filter_labels', $filterLabels);
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
        $typeEts = SessionController::getInstance()->getUserTypeEts();
        $userLat = SessionController::getInstance()->getUserLat();
        $userLng = SessionController::getInstance()->getUserLng();
        $userLatLng = new LatLng($userLat, $userLng);
        
        $terms = Request::get('term');
        $distance = self::getFilterValues('distance', self::DEFAULT_DISTANCE_KM_SEARCH);
        $orderBy = self::getFilterValues('order_by', self::SEARCH_ORDER_BY_PROXIMITY);
        
        if($userLatLng->isValid()){
            $businessCategoryType = null;
            switch($typeEts){
                case Establishment::TYPE_BUSINESS_RESTAURANT:
                    $businessCategoryType = BusinessCategory::TYPE_COOKING_TYPE;
                    break;
            }
            
            // Search by proximity
            $squareCoordinates = GeolocTools::getSquareCoordinates($userLatLng, $distance*1000);
            
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
                            ->select(DB::raw(Establishment::TABLENAME.'.*, '.Address::TABLENAME.'.*, '.BusinessCategory::TABLENAME.'.name as type_category'
                                    .','.GeolocTools::genRawSqlForDistanceCalculation($userLatLng, Establishment::TABLENAME)))
                            ->join(Address::TABLENAME, Address::TABLENAME.'.id', '=', Establishment::TABLENAME.'.id_address')
                            ->join(EstablishmentBusinessCategory::TABLENAME, Establishment::TABLENAME.'.id', '=', EstablishmentBusinessCategory::TABLENAME.'.id_establishment')
                            ->join(BusinessCategory::TABLENAME, BusinessCategory::TABLENAME.'.id', '=', EstablishmentBusinessCategory::TABLENAME.'.id_business_category')
                            ->where(Establishment::TABLENAME.'.name', 'LIKE', "%$terms%")
                            ->where(Establishment::TABLENAME.'.id_business_type', '=', $typeEts)
//                            ->having('rawDistance', '<=', ($distance*1000))
                            ->whereBetween(Establishment::TABLENAME.'.latitude', array($minLat, $maxLat))
                            ->whereBetween(Establishment::TABLENAME.'.longitude', array($minLng, $maxLng))
                            ;
                if(!empty($businessCategoryType)){
                    $establishmentsQuery->where(BusinessCategory::TABLENAME.'.type', '=', $businessCategoryType);
                }
                
                switch($orderBy){
                    default :
                    case self::SEARCH_ORDER_BY_PROXIMITY:
                        $establishmentsQuery->orderBy('rawDistance');
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
            $nbElementPerPage = self::getFilterValues('display_by', self::DEFAULT_DISPLAY_BY);
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $sliceStart = ($currentPage - 1) * $nbElementPerPage;
            $nbTotalResults = $searchQuery->count();
            $searchQuery->offset($sliceStart)->limit($nbElementPerPage);
            
            $distance = self::getFilterValues('distance', self::DEFAULT_DISTANCE_KM_SEARCH);
            $establishmentsData = $searchQuery->get();
            foreach($establishmentsData as $establishmentData){    
                if($establishmentData->rawDistance <= ($distance*1000)){
                    $uuid = UuidTools::getUuid($establishmentData->id);
                    $establishments[$uuid]['id'] = $uuid;
                    $establishments[$uuid]['name'] = $establishmentData->name;
                    $establishments[$uuid]['img'] = "/img/images_ds/imagen-DS-".rand(1, 20).".jpg";
                    $establishments[$uuid]['city'] = $establishmentData->city;
                    $establishments[$uuid]['country'] = $establishmentData->country;
                    $establishments[$uuid]['type_category'] = $establishmentData->type_category;
                    $establishments[$uuid]['raw_distance'] = \App\Utilities\StringTools::displayCleanDistance($establishmentData->rawDistance);
                }
            }
            
            // Paginate results
            $resultsPagination = new LengthAwarePaginator($establishments, $nbTotalResults, $nbElementPerPage);
            $resultsPagination->setPath(Request::url());
        }
        return $resultsPagination;
    }
    
    public static function buildFilterLabels(){
        $orderBy =array(
                        self:: SEARCH_ORDER_BY_PROXIMITY => "Proximité",
                        self:: SEARCH_ORDER_BY_NAME => "Nom"
                     );
        $displayBy = self::$nbElementsPerPageChoices;
        \App\Utilities\StorageHelper::getInstance()->add('search.filter_data.order_by', $orderBy);
        \App\Utilities\StorageHelper::getInstance()->add('search.filter_data.display_by', $displayBy);
    }
    
    public static function setFilterValues($key, $value){
        SessionController::getInstance()->addSearchFilterValue($key, $value);
    }
    
    public static function getFilterValues($key, $defaultValue = null){
        if(Request::exists($key)){
            $value = Request::get($key);
            SessionController::getInstance()->addSearchFilterValue($key, $value);
        } else {
            $value = SessionController::getInstance()->getSearchFilterValue($key, $defaultValue);
        }
        return $value;
    }
}
