<?php

namespace App\Http\Requests;

class StoreEstablishment extends \App\Http\FormRequest {

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
        return [
            //Emplacement validation
            'name' => 'required|min:2|max:255',
            'address.street' => 'required|min:3|max:255',
            'address.street_number' => 'required|max:45',
            'address.postal_code' => 'required|max:11',
            'address.city' => 'required|max:255',
            'address.id_country' => 'required',
            //Contact validation
            /*
            'numberReservation' => 'required|min:11|numeric',
            'contactNumber' => 'required|min:11|numeric',
            'fax' => 'nullable|min:11|numeric',
            'mobile' => 'nullable|min:11|numeric',
             */
            //Web validation
            'site_url' => 'nullable|active_url',    
            'email' => 'nullable|email',
            //cooking type
            'cooking_types' => 'required|array|min:1',
            //horaire
            'startTimeAm1'    => 'nullable|date_format:H:i|before:endTimeAm1',
        ];
    }

    public function messages() {
        return [
            //Emplacement msg
            'name.required' => 'Veuillez saisir le nom de votre restaurant.',
            'name.min' => 'Veuillez renseigner au minimum 2 caractère pour le nom de votre restaurant',
            'name.max' => 'Merci de ne pas renseigner plus de 255 caractère pour le nom de votre restaurant',
            'address.street.required' => 'Veuillez saisir une adresse pour votre établissement.',
            'address.street.min' => 'Le nom de la rue dois contenir au minimum 3 caractères.',
            'address.street_number.required' => 'Vous devez spécifiez un numéro de rue.',
            'address.postal_code.required' => 'Vous devez spécifier un code postal.',
            'address.city.required' => 'Vous devez spécifiez une ville pour votre établissement.',
            'address.country.required' => 'Vous devez spécifiez le pays de votre établissement.',
            'latitude.required' => 'Veuillez cliquer sur le bouton Géolocaliser mon établissemnt.',
            'longitude.required' => 'Veuillez cliquer sur le bouton Géolocaliser mon établissemnt.',
            //contact
            'numberReservation.required' => 'Veuillez indiquer un numéro de résérvation.',
            'numberReservation.max' => 'Le numéro ne doit pas contenir plus de 11 numéro.',
            'numberReservation.numeric' => 'Le numéro de résérvation de dois pas contenir de caractères',
            'contactNumber.required' => 'Veuillez indiquer un numéro pour vous joindre.',
            'contactNumber.min' => 'Le numéro ne doit pas contenir plus de 11 numéro.',
            'contactNumber.numeric' => 'Le numéro de résérvation de dois pas contenir de caractères', 
            'fax.numeric' => 'Le numéro de fax ne doit pas contenir plus de 11 numéro.',
            'mobile.numeric' => 'Le numéro de résérvation de dois pas contenir de caractères', 
            //Web
            'site_url.active_url' => 'Veuillez saisir une adresse correcte pour votre site internet.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'email.required' => 'Veuillez saisir une adresse email de contact.',
            //cooking type
            'cooking_types.required' => 'Veuillez séléctioner au minimum un types de cuisine pour être correctement référencer par l\'application',
            'cooking_types.required' => 'veuillez spécifiez au minimum un type de cuisine',
            'cooking_types.array' => 'veuillez spécifiez au minimum un type de cuisine',
        ];
    }
}
