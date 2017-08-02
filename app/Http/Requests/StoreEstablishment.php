<?php

namespace App\Http\Requests;

class StoreEstablishment extends \App\Http\FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'establishment.name' => 'required|min:2|max:255',
            'street' => 'required|min:3|max:255',
            'street_number' => 'required|max:45',
            'postal_code' => 'required|max:11',
            'city' => 'required|max:255',
            'country' => 'required|max:255',
            'latitude' => 'required',
            'longitude' => 'required',
            /*
            'numberReservation' => 'required|min:11|numeric',
            'contactNumber' => 'required|min:11|numeric',
            
            'site_url' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',*/
        ];
    }
    
    public function messages(){
        return [
            'establishment.name.required' => ' Vous devez spécifier un nom pour votre établissement.',
            'establishment.name.min' => ' Le nom de votre restaurant dois contenir au minimum 2 caractères.',
            'establishment.name.max' => ' Le nom du restaurant ne dois pas dépasser 255 caractères',
            'street.required' => 'Vous devez spécifiez une rue pour votre établissement',
            'street.min' => 'Le nom de rue dois contenir au minimum 3 caractères',
            'street_number.required' => ' Vous devez spécifiez un numéro de rue pour votre établissement.',
            'postal_code.required' => 'Vous devez spécifier un code postal',
            'city.required' => ' Vous devez spécifiez une ville pour votre établissement.',
            'country.required' => ' Vous devez spécifiez le pays de votre établissement.',
            'latitude.required' => 'Veuillez cliquer sur le bouton localisation de mon restaurant.',
            'longitude.required' => 'Veuillez cliquer sur le bouton localisation de mon restaurant.',
            /*
            'numberReservation.required' => 'Veuillez indiquer un numéro de résérvation.',
            'numberReservation.min' => 'Le numéro ne doit pas contenir plus de 11 numéro.',
            'numberReservation.numeric' => 'Le numéro de résérvation de dois pas contenir de caractères',
            'contactNumber.required' => 'Veuillez indiquer un numéro pour vous joindre.',
            'contactNumber.min' => 'Le numéro ne doit pas contenir plus de 11 numéro.',
            'contactNumber.numeric' => 'Le numéro de résérvation de dois pas contenir de caractères',
            
            'site_url.regex' => 'Veuillez.',
            'site_url' => 'requis pour toto',*/
        ];
    }
}
