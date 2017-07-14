<?php

namespace App\Models\Utilities;

/**
 * Description of LatLng
 *
 * @author Nico
 */
class LatLng {
    private $lng = 0.0;
    private $lat = 0.0;
    
    function __construct($lat, $lng) {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    function getLng() {
        return $this->lng;
    }

    function getLat() {
        return $this->lat;
    }

    function setLng($lng) {
        $this->lng = $lng;
    }

    function setLat($lat) {
        $this->lat = $lat;
    }

    public function getSquareLimitCoordinates(){
        return \App\Utilities\GeolocTools::getSquareCoordinates($this);
    }
    
    public function isValid(){
        $isValid = false;
        if(!empty($this->getLat()) && !empty($this->getLng())){
            $isValid = true;
        }
        return $isValid;
    }
}
