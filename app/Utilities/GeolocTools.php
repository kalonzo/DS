<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utilities;

use App\Models\Utilities\LatLng;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/**
 * Description of GeolocTools
 *
 * @author Nico
 */
class GeolocTools {

    const LAT_DEGREES_FOR_METER = 9.000090000900009e-6; // 1° = 111,11km
    const EARTH_RADIUS = 6378137;   // Terre = sphère de 6378km de rayon

    /**
     * 
     * @param LatLng $latLng
     * @param type $distance
     * @return LatLng
     */

    public static function getSquareCoordinates(LatLng $latLng, $distance = 5000) {
        $coordinates = array();

        $topLeftLat = $latLng->getLat() - ($distance * self::LAT_DEGREES_FOR_METER);
        $topLeftLng = $latLng->getLng() - ($distance * self::getLngDegreesPerMeter($topLeftLat));
        $coordinates[] = new LatLng($topLeftLat, $topLeftLng);

        $topRightLat = $latLng->getLat() - ($distance * self::LAT_DEGREES_FOR_METER);
        $topRightLng = $latLng->getLng() + ($distance * self::getLngDegreesPerMeter($topLeftLat));
        $coordinates[] = new LatLng($topRightLat, $topRightLng);

        $bottomLeftLat = $latLng->getLat() + ($distance * self::LAT_DEGREES_FOR_METER);
        $bottomLeftLng = $latLng->getLng() - ($distance * self::getLngDegreesPerMeter($topLeftLat));
        $coordinates[] = new LatLng($bottomLeftLat, $bottomLeftLng);

        $bottomRightLat = $latLng->getLat() + ($distance * self::LAT_DEGREES_FOR_METER);
        $bottomRightLng = $latLng->getLng() + ($distance * self::getLngDegreesPerMeter($topLeftLat));
        $coordinates[] = new LatLng($bottomRightLat, $bottomRightLng);

        return $coordinates;
    }

    public static function getLngDegreesPerMeter($lat) {
        $lngMetersPerDegree = 1 / (111.11 * 1000 * cos($lat));
        return $lngMetersPerDegree;
    }

    public static function calculateRawDistance(LatLng $fromLatLng, LatLng $toLatLng) {
        $distance = null;
        if ($fromLatLng->isValid() && $toLatLng->isValid()) {
            $rlo1 = deg2rad($fromLatLng->getLng());
            $rla1 = deg2rad($fromLatLng->getLat());
            $rlo2 = deg2rad($toLatLng->getLng());
            $rla2 = deg2rad($toLatLng->getLat());
            $dlo = ($rlo2 - $rlo1) / 2;
            $dla = ($rla2 - $rla1) / 2;
            $a = (sin($dla) * sin($dla)) + cos($rla1) * cos($rla2) * (sin($dlo) * sin($dlo));
            $d = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $distance = self::EARTH_RADIUS * $d;
        }
        return $distance;
    }

    public static function getClientIP() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])){
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        }else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else if (isset($_SERVER['HTTP_X_FORWARDED'])){
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        }else if (isset($_SERVER['HTTP_FORWARDED_FOR'])){
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        }else if (isset($_SERVER['HTTP_FORWARDED'])){
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        }else if (isset($_SERVER['REMOTE_ADDR'])){
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        }else{
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }

    public static function getTimezoneFromCountryIso($iso){
        $timezoneArray = \DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, $iso);
        $timezone = $timezoneArray[0];
        return $timezone;
    }
}
