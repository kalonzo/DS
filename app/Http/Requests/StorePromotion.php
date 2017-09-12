<?php

namespace App\Http\Requests;

class StorePromotion extends \App\Http\FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {


        if ($this->ajax() === true) {
            echo 'test ajax';
        } else {
            echo 'test normal';

            //minima maxima for dishes
            $min = $this->get('average_price_min');
            $max = $this->get('average_price_max');
            $rules = [
                //self::$rules_phone,
                // Location
                'name' => 'required|min:2|max:255',
            ];

            return $rules;
        }
    }

    public function messages() {
        $messages = [
                //Emplacement msg
        ];

        return $messages;
    }

}
