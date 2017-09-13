<?php

namespace App\Http;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

/**
 * Description of FormRequest
 *
 * @author Nico
 */
class FormRequest extends BaseFormRequest{
    use ExtendRequestTrait;
    
    public function get($key, $default = NULL){
        if(strpos($key, ".") !== false){
            return $this->getWithDot($key, $default);
        } else {
            return BaseFormRequest::get($key, $default);
        }
    }
}
