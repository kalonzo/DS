<?php

namespace App\Http\Controllers;

use App\Models\BusinessCategory;
use App\Models\EstablishmentBusinessCategory;
use App\Models\Restaurant;
use App\Models\Utilities\LatLng;
use App\Utilities\GeolocTools;
use Illuminate\Support\Facades\DB;

/**
 * Description of SearchController
 *
 * @author Nico
 */
class SearchController {
    const NB_QUICK_RESULTS_PER_TYPE = 1;
    
    const QUICK_SEARCH_SECTION_DISTANCE = 1;
    const QUICK_SEARCH_SECTION_NAME = 2;
    const QUICK_SEARCH_SECTION_COOKING_TYPE = 3;
    
    public static function quickSearch($terms){
        $results = array();
        $userLat = SessionController::getInstance()->getUserLat();
        $userLng = SessionController::getInstance()->getUserLng();
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
                                        ->whereBetween('latitude', array($minLat, $maxLat))
                                        ->whereBetween('longitude', array($minLng, $maxLng))
                                        ;
                $rawDistanceList = array();
                $rawDistanceRestaurants = $rawDistanceRestaurantsQuery->get();
                foreach($rawDistanceRestaurants as $rawDistanceRestaurant){
                    $rawDistance = GeolocTools::calculateRawDistance($userLatLng, $rawDistanceRestaurant->getLatLng());
                    $rawDistanceList[$rawDistance] = $rawDistanceRestaurant;
                }
                asort($rawDistanceList);
                foreach($rawDistanceList as $distance => $restaurant){
                    $results [] = array(
                            'id' => $restaurant->getId(),
                            'label' => $restaurant->getName(),
                            'section' => 'Top Résultats',
                            'section_id' => self::QUICK_SEARCH_SECTION_DISTANCE,
                            'distance' => $distance
                        );
                }

                // Search by alphabetic
                $alphabetRestaurants = $rawDistanceRestaurantsQuery->orderBy('name')->limit(self::NB_QUICK_RESULTS_PER_TYPE)->get();
                foreach($alphabetRestaurants as $distance => $restaurant){
                    $results [] = array(
                            'id' => $restaurant->getId(),
                            'label' => $restaurant->getName(),
                            'section' => 'Nom',
                            'section_id' => self::QUICK_SEARCH_SECTION_NAME
                        );
                }
                
                // Search by cooking type
                $cookingTypesResults = BusinessCategory::select(DB::raw('count('.EstablishmentBusinessCategory::TABLENAME.'.id_establishment'.') as nb_establishment, '
                                                                        .BusinessCategory::TABLENAME.'.id, '.BusinessCategory::TABLENAME.'.name'))
                    ->join(EstablishmentBusinessCategory::TABLENAME, EstablishmentBusinessCategory::TABLENAME.'.id_business_category', '=', BusinessCategory::TABLENAME.'.id')
//                        ->join(Establishment::TABLENAME, EstablishmentBusinessCategory::TABLENAME.'.id_establishment', '=', Establishment::TABLENAME.'.id')
                    ->where(BusinessCategory::TABLENAME.'.name', 'LIKE', "%$terms%")
                    ->where(BusinessCategory::TABLENAME.'.type', '=', BusinessCategory::TYPE_COOKING_TYPE)
                    ->groupBy(BusinessCategory::TABLENAME.'.id')
                    ->orderBy(BusinessCategory::TABLENAME.'.name')
                    ->limit(self::NB_QUICK_RESULTS_PER_TYPE)
                    ->get()
                    ;
                foreach($cookingTypesResults as $result){
                    $results [] = array(
                            'id' => $result->id_business_category,
                            'label' => $result->name.' ('.$result->nb_establishment.')',
                            'section' => 'Type de cuisine',
                            'section_id' => self::QUICK_SEARCH_SECTION_COOKING_TYPE
                        );
                }
                
                $results [] = array(
                            'id' => 0,
                            'label' => "Resto test",
                            'section' => 'Test'
                        );
            }
        }
        
        return $results;
    }
}
