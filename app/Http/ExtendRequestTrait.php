<?php

namespace App\Http;

/**
 * Description of ExtendRequestTrait
 *
 * @author Nico
 */
trait ExtendRequestTrait {
    
    public function get($key, $default = NULL){
        if(strpos($key, ".") !== false){
            $keys = explode('.', $key);
            $offset = null;
            $nbSubKeys = count($keys);
            $counter = 1;
            
            $sourceArray = $this->all();
            $arrayCursor = &$sourceArray;
            foreach($keys as $subkey){
                if(array_key_exists($subkey, $arrayCursor)){
                    if($counter === $nbSubKeys){
                        $offset = $subkey;
                    } else {
                        $arrayCursor =  &$arrayCursor[$subkey];
                    }
                } else {
                    return parent::get($key, $default);
//                    return $this->route($key);
                }
                $counter++;
            }
            if(!empty($offset)){
                return data_get($arrayCursor, $offset, $default);
            }
        } else {
            return parent::get($key, $default);
        }
    }
}
