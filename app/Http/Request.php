<?php

namespace App\Http;


/**
 * Description of Request
 *
 * @author Nico
 */
class Request extends \Illuminate\Http\Request{
    use ExtendRequestTrait;
    
    public function get($key, $default = NULL){
        if(strpos($key, ".") !== false){
            return $this->getWithDot($key, $default);
        } else {
            return parent::get($key, $default);
        }
    }
}
