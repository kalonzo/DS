<?php

namespace App\Http\Controllers;

/**
 * Description of SessionController
 *
 * @author Nico
 */
class SessionController {
    
    private $userLng = null;
    private $userLat = null;
    private $typeEts = null;
    
    function getUserLng() {
        return \Illuminate\Support\Facades\Request::session()->get('user.lng');
    }

    function getUserLat() {
        return \Illuminate\Support\Facades\Request::session()->get('user.lat');
    }

    function setUserLng($userLng) {
        \Illuminate\Support\Facades\Request::session()->put('user.lng', $userLng);
    }

    function setUserLat($userLat) {
        \Illuminate\Support\Facades\Request::session()->put('user.lat', $userLat);
    }

    function getUserTypeEts() {
        $this->typeEts = \Illuminate\Support\Facades\Request::session()->get('user.type_ets');
        if($this->typeEts === null || empty($this->typeEts)){
            $this->typeEts = \App\Models\Establishment::TYPE_BUSINESS_RESTAURANT;
        }
        return $this->typeEts;
    }

    function setUserTypeEts($userTypeEts) {
        \Illuminate\Support\Facades\Request::session()->put('user.type_ets', $userTypeEts);
    }
        
    /******************* SINGLETON MANAGEMENT *********************************/
    
    private static $instance = null;
    private function __construct(){}
    
    /**
     * 
     * @return SessionController
     */
    public static function getInstance(){
        if(self::$instance == null){
            self::setInstance(new self());
        }
        return self::$instance;
    }

    public static function setInstance(SessionController $controller){
        if($controller != null){
            self::$instance = $controller ;
        }
    }
}