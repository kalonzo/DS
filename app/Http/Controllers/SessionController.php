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
    private $searchFilterValues = null;
    
    function getUserLng() {
        if($this->userLng === null){
            $this->userLng = \Illuminate\Support\Facades\Request::session()->get('user.lng');
        }
        return $this->userLng;
    }

    function getUserLat() {
        if($this->userLat === null){
            $this->userLat = \Illuminate\Support\Facades\Request::session()->get('user.lat');
        }
        return $this->userLat;
    }

    function setUserLng($userLng) {
        \Illuminate\Support\Facades\Request::session()->put('user.lng', $userLng);
    }

    function setUserLat($userLat) {
        \Illuminate\Support\Facades\Request::session()->put('user.lat', $userLat);
    }

    function getUserTypeEts() {
        if($this->typeEts === null){
            $this->typeEts = \Illuminate\Support\Facades\Request::session()->get('user.type_ets');
            if($this->typeEts === null || empty($this->typeEts)){
                $this->typeEts = \App\Models\Establishment::TYPE_BUSINESS_RESTAURANT;
            }
        }
        return $this->typeEts;
    }

    function setUserTypeEts($userTypeEts) {
        \Illuminate\Support\Facades\Request::session()->put('user.type_ets', $userTypeEts);
    }
    
    function addSearchFilterValue($key, $value){
        $this->loadSearchFilterValues();
        $this->searchFilterValues[$key] = $value;
        return $value;
    }
    
    function getSearchFilterValue($key, $defaultValue = null, $autoset = true){
        $this->loadSearchFilterValues();
        $value = $defaultValue;
        if(isset($this->searchFilterValues[$key])){
            $value = $this->searchFilterValues[$key];
        } else if($autoset){
            $value = $this->addSearchFilterValue ($key, $defaultValue);
        }
        return $value;
    }
    
    function removeSearchFilterValue($key){
        $this->loadSearchFilterValues();
        unset($this->searchFilterValues[$key]);
    }
    
    function saveSearchFilterValues(){
        $this->loadSearchFilterValues();
        \Illuminate\Support\Facades\Request::session()->put('search', $this->searchFilterValues);
    }
    
    function resetSearchFilterValues(){
        $this->searchFilterValues = array();
        \Illuminate\Support\Facades\Request::session()->put('search', $this->searchFilterValues);
    }
    
    function loadSearchFilterValues(){
        if($this->searchFilterValues === null){
            $this->searchFilterValues = \Illuminate\Support\Facades\Request::session()->get('search');
            if($this->searchFilterValues === null){
                $this->searchFilterValues = array();
            }
        }
    }
    
    function getSearchFilterValues($sessionSave = true){
        $this->loadSearchFilterValues();
        if($sessionSave){
            $this->saveSearchFilterValues();
        }
        return $this->searchFilterValues;
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