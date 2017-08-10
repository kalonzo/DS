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
        $rules = [
            // Location
            'name' => 'required|min:2|max:255',
            'address.street' => 'required|min:3|max:255',
            'address.street_number' => 'required|max:45',
            'address.postal_code' => 'required|max:11',
            'address.city' => 'required|max:255',
            'address.id_country' => 'required',

            // Call numbers
            'call_number.1' => 'required|min:11|numeric',
            'call_number.4' => 'required|min:11|numeric',
            'call_number.3' => 'nullable|min:11|numeric',
            'call_number.2' => 'nullable|min:11|numeric',
            
            //Web 
            'site_url' => 'nullable|regex:/^(https?:\/\/)?([\a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ._-da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',  
            'email' => 'nullable|email',
            
            // Cooking types
            'businessCategories.1' => 'required|array|min:1',
        ];
        /*
        // Opening hours
        foreach(\App\Utilities\DateTools::getDaysArray() as $dayIndex => $dayLabel){
            $rules['openingHours.'.$dayIndex.'1.start'] = 'required|array|before_or_equal:openingHours.'.$dayIndex.'1.end';
            $rules['openingHours.'.$dayIndex.'2.start'] = 'required|array|before_or_equal:openingHours.'.$dayIndex.'2.end';
            $rules['openingHours.'.$dayIndex.'1.end'] = 'required|array';
            $rules['openingHours.'.$dayIndex.'2.end'] = 'required|array';
        }
         * 
         */
        return $rules;
    }

    public function messages() {
        $messages = [
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
            'call_number.1.required' => 'Veuillez indiquer un numéro de résérvation.',
            'call_number.1.numeric' => 'Veuillez indiquer un numéro de résérvation.',
            'call_number.1.max' => 'Le numéro ne doit pas contenir plus de 11 numéro.',
            'call_number.4.numeric' => 'Le numéro de contact ne de dois pas contenir de caractères',
            'call_number.4.required' => 'Veuillez indiquer un numéro pour vous joindre.',
            'call_number.4.max' => 'Le numéro ne doit pas contenir plus de 11 numéro.',
            'call_number.3.numeric' => 'Le numéro de fax ne doit pas contenir plus de 11 numéro.',
            'call_number.2.numeric' => 'Le numéro de résérvation de dois pas contenir de caractères', 
            //Web
            'site_url.regex' => 'Veuillez saisir une adresse correcte pour votre site internet.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
            //cooking type
            'cooking_types.required' => 'Veuillez séléctioner au minimum un types de cuisine pour être correctement référencer par l\'application',
            'cooking_types.array' => 'veuillez spécifiez au minimum un type de cuisine',
        ];
        // Opening hours
        foreach(\App\Utilities\DateTools::getDaysArray() as $dayIndex => $dayLabel){
            $messages['openingHours.'.$dayIndex.'1.start.before_or_equal'] = "L'heure de fermeture du ".strtolower($dayLabel)
                                                                                ." matin doit être supérieure à l'heure d'ouverture";
            $messages['openingHours.'.$dayIndex.'2.start.before_or_equal'] = "L'heure de fermeture du ".strtolower($dayLabel)
                                                                                ." après-midi doit être supérieure à l'heure d'ouverture";
            $messages['openingHours.'.$dayIndex.'1.start'] = "Veuillez saisir l'heure d'ouverture du ".$dayLabel." après-midi";
            $messages['openingHours.'.$dayIndex.'1.end'] = "Veuillez saisir l'heure de fermeture du ".$dayLabel." après-midi";
            $messages['openingHours.'.$dayIndex.'2.start'] = "Veuillez saisir l'heure d'ouverture du ".$dayLabel." après-midi";
            $messages['openingHours.'.$dayIndex.'2.end'] = "Veuillez saisir l'heure de fermeture du ".$dayLabel." après-midi";
        }
        return $messages;
    }
}
