<?php

namespace App\Utilities;

/**
 * Description of StorageHelper
 *
 * @author Nico
 */
class StorageHelper {
    
    private $storage = array();
    
    public function add($key, $value){
        $keys = explode('.', $key);
        $nbSubKeys = count($keys);
        
        $counter = 1;
        $arrayCursor = &$this->storage;
        foreach($keys as $subkey){
            if(!isset($arrayCursor[$subkey])){
                $arrayCursor[$subkey] = array();
            }
            if($counter < $nbSubKeys){
                $arrayCursor =  &$arrayCursor[$subkey];
            } else {
                $arrayCursor[$subkey] = $value;
            }
            $counter++;
        }
    }
    
    public function get($key){
        $keys = explode('.', $key);
        $arrayCursor = &$this->storage;
        foreach($keys as $subkey){
            if(isset($arrayCursor[$subkey])){
                $arrayCursor =  &$arrayCursor[$subkey];
            }
        }
        return $arrayCursor;
    }
    
    /******************* SINGLETON MANAGEMENT *********************************/
    
    private static $instance = null;
    private function __construct(){}
    
    /**
     * 
     * @return StorageHelper
     */
    public static function getInstance(){
        if(self::$instance == null){
            self::setInstance(new self());
        }
        return self::$instance;
    }

    public static function setInstance(StorageHelper $controller){
        if($controller != null){
            self::$instance = $controller ;
        }
    }
}
