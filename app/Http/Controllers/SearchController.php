<?php

namespace App\Http\Controllers;

use App\Models\Utilities\LatLng;
use App\Utilities\GeolocTools;

/**
 * Description of SearchController
 *
 * @author Nico
 */
class SearchController {
    public static function quickSearch($terms){
        $results = array();
        $userLat = SessionController::getInstance()->getUserLat();
        $userLng = SessionController::getInstance()->getUserLng();
        $userLatLng = new LatLng($userLat, $userLng);
        if(!empty($terms) && $userLatLng->isValid()){
            $squareCoordinates = GeolocTools::getSquareCoordinates($userLatLng);
            
            $minLat = 0.0;
            $minLng = 0.0;
            $maxLat = 0.0;
            $maxLng = 0.0;
            foreach($squareCoordinates as $squareCoordinate){
                if($minLat === 0 || $squareCoordinate->getLat() < $minLat){
                    $minLat = $squareCoordinate->getLat();
                }
                if($minLng === 0 || $squareCoordinate->getLng() < $minLng){
                    $minLng = $squareCoordinate->getLng();
                }
                if($maxLat === 0 || $squareCoordinate->getLat() > $maxLat){
                    $maxLat = $squareCoordinate->getLat();
                }
                if($maxLng === 0 || $squareCoordinate->getLng() > $maxLng){
                    $maxLng = $squareCoordinate->getLng();
                }
            }
            
            if(!empty($minLat) && !empty($maxLat) && !empty($minLng) && !empty($maxLng)){
                $rawDistanceRestaurants = \App\Models\Restaurant::whereBetween('latitude', array($minLat, $maxLat))
                                        ->whereBetween('longitude', array($minLng, $maxLng))
                                        ;
                $rawDistanceList = array();
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
                            'distance' => $distance
                        );
                }
            }
            
            $results [] = array(
                            'label' => 'resto1',
                            'section' => 'Top Résultats',
                        );
            
        }
        return $results;
    }
}
