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
            'cooking_types' => 'required|min:1'
            /*
            'numberReservation' => 'required|min:11|numeric',
            'contactNumber' => 'required|min:11|numeric',
            
            'site_url' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',*/
        ];
    }
    
    public function messages(){
        return [
            'establishment.name.required' => 'Veuillez saisir le nom de votre restaurant.',
            'establishment.name.min' => 'Veuillez rendeigner au minimum 2 caractère pour le nom de votre restaurant',
            'establishment.name.max' => 'Merci de ne pas renseigner plus de 255 caractère pour le nom de votre restaurant',
            'street.required' => 'Veuillez remplir ce champ.',
            'street.min' => 'Le nom de rue dois contenir au minimum 3 caractères.',
            'street_number.required' => 'Vous devez spécifiez un numéro de rue.',
            'postal_code.required' => 'Vous devez spécifier un code postal.',
            'city.required' => 'Vous devez spécifiez une ville pour votre établissement.',
            'country.required' => 'Vous devez spécifiez le pays de votre établissement.',
            'latitude.required' => 'Veuillez cliquer sur le bouton Géolocaliser mon établissemnt.',
            'longitude.required' => 'Veuillez cliquer sur le bouton Géolocaliser mon établissemnt.',
            'cooking_types.required' => 'veuillez spécifiez au minimum un type de cuisine',
            /*
            'numberReservation.required' => 'Veuillez indiquer un numéro de résérvation.',
            'numberReservation.min' => 'Le numéro ne doit pas contenir plus de 11 numéro.',
            'numberReservation.numeric' => 'Le numéro de résérvation de dois pas contenir de caractères',
            'contactNumber.required' => 'Veuillez indiquer un numéro pour vous joindre.',
            'contactNumber.min' => 'Le numéro ne doit pas contenir plus de 11 numéro.',
            'contactNumber.numeric' => 'Le numéro de résérvation de dois pas contenir de caractères',
            
            'site_url.regex' => 'Le format de votre site n'est pas valide (MonRestaurant.com)',
            'site_url' => 'requis pour toto',*/
        ];
    }
}
