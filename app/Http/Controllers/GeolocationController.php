<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeolocationController extends Controller
{
    const DEFAULT_COUNTRY = 'ch';
    const DEFAULT_LANG = 'fr';
    static $geolocArrayByCountryLanguage = array(   self::DEFAULT_COUNTRY => array(
                                                                self::DEFAULT_LANG => array('lat' => 46.204549, 'lng' => 6.144775), // Geneva
                                                                'de' => array('lat' => 47.376969, 'lng' => 8.540833), // Zurich
                                                                'it' => array('lat' => 46.003654, 'lng' => 8.952918), // Lugano
                                                                ),
                                                    'fr' => array(
                                                                self::DEFAULT_LANG => array('lat' => 46.204905, 'lng' => 6.144775), // Geneva
                                                                ),
                                            );
    
    /**
     * 
     * @return \App\Models\Utilities\LatLng
     */
    public static function getRawInitialGeolocation(){
        $geoloc = null;
        // From IP, see http://ipinfo.io/developers
        
        // From user accepted language
        $acceptedLanguages = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $acceptedLanguagesArray = explode(';', $acceptedLanguages);
        if(!empty($acceptedLanguagesArray) && isset($acceptedLanguagesArray[0])){
            $prioLanguageArray = explode(',', $acceptedLanguagesArray[0]);
            if(!empty($prioLanguageArray) && isset($prioLanguageArray[0])){
                $langCountryArray = explode('-', $prioLanguageArray[0]);
                if(!empty($langCountryArray) && count($langCountryArray) === 2){
                    $lang = strtolower($langCountryArray[0]);
                    $country = strtolower($langCountryArray[1]);
                    
                    $defaultCountry = self::DEFAULT_COUNTRY;
                    $defaultlang = self::DEFAULT_LANG;
                    if(isset(self::$geolocArrayByCountryLanguage[$country])){
                        $defaultCountry = $country;
                        if(isset(self::$geolocArrayByCountryLanguage[$country][$lang])){
                            $defaultlang = $lang;
                        }
                    }
                    $geolocArray = self::$geolocArrayByCountryLanguage[$defaultCountry][$defaultlang];
                    if(!empty($geolocArray) && count($geolocArray) === 2){
                        $geoloc = new \App\Models\Utilities\LatLng($geolocArray['lat'], $geolocArray['lng']);
                    }
                }
            }
        }
        return $geoloc;
    }
    
    public static function getLocaleCountry(){
        return \Illuminate\Support\Facades\App::getLocale();
    }
    
}
