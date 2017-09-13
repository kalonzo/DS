<?php

namespace App\Http;

/**
 * Description of ExtendRequestTrait
 *
 * @author Nico
 */
trait ExtendRequestTrait {
    public function getWithDot($key, $default = NULL){
        $result = null;
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
                    $result = $this->route($key);
                }
                $counter++;
            }
            if(!empty($offset)){
                $result = data_get($arrayCursor, $offset);
            }
        }
        return $result;
    }
    
}
