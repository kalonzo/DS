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
            'address.region' => 'required|max:255',
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
        // Opening hours
        foreach (\App\Utilities\DateTools::getDaysArray() as $dayIndex => $dayLabel) {
            $rules['openingHours.' . $dayIndex . '.1.start'] = 'required'; //|before_or_equal:openingHours.'.$dayIndex.'.1.end';
            $rules['openingHours.' . $dayIndex . '.1.end'] = 'required';

            $rules['openingHours.' . $dayIndex . '.2.start'] = 'required_unless:openingHours.' . $dayIndex . '.2.no_break,1|after_or_equal:openingHours.' . $dayIndex . '.1.end'
            ; //.'before_or_equal:openingHours.'.$dayIndex.'.2.end';
            $rules['openingHours.' . $dayIndex . '.2.end'] = 'required_unless:openingHours.' . $dayIndex . '.2.no_break,1';
        }
        return $rules;
    }

    public function messages() {
        $messages = [
            //Emplacement msg
            'name.required' => 'Veuillez saisir le nom de votre restaurant.',
            'name.min' => 'Veuillez renseigner au minimum 2 caractères pour le nom de votre restaurant',
            'name.max' => 'Merci de ne pas renseigner plus de 255 caractères pour le nom de votre restaurant',
            'address.street.required' => 'Veuillez saisir une adresse pour votre établissement.',
            'address.street.min' => 'Le nom de la rue doit contenir au minimum 3 caractères.',
            'address.street_number.required' => 'Vous devez spécifier un numéro de rue.',
            'address.postal_code.required' => 'Vous devez spécifier un code postal.',
            'address.region.required' => 'Vous devez spécifier une région pour votre établissement.',
            'address.region.max' => 'Merci de ne pas renseigner plus de 255 caractères pour la région de votre établissement.',
            'address.city.required' => 'Vous devez spécifier une ville pour votre établissement.',
            'address.city.max' => 'Merci de ne pas renseigner plus de 255 caractères pour la ville de votre établissement.',
            'address.country.required' => 'Vous devez spécifiez le pays de votre établissement.',
            'latitude.required' => 'Veuillez cliquer sur le bouton Géolocaliser mon établissement.',
            'longitude.required' => 'Veuillez cliquer sur le bouton Géolocaliser mon établissement.',
            //contact
            'call_number.1.required' => 'Veuillez indiquer un numéro de réservation.',
            'call_number.1.numeric' => 'Veuillez indiquer un numéro de réservation.',
            'call_number.1.max' => 'Le numéro ne doit pas contenir plus de 11 numéro.',
            'call_number.4.numeric' => 'Le numéro de contact ne ne doit pas contenir de caractères',
            'call_number.4.required' => 'Veuillez indiquer un numéro pour vous joindre.',
            'call_number.4.max' => 'Le numéro ne doit pas contenir plus de 11 numéro.',
            'call_number.3.numeric' => 'Le numéro de fax ne doit pas contenir plus de 11 numéro.',
            'call_number.2.numeric' => 'Le numéro de réservation ne doit pas contenir de caractères',
            //Web
            'site_url.regex' => 'Veuillez saisir une adresse correcte pour votre site internet.',
            'email.email' => 'Veuillez saisir une adresse e mail valide.',
            //cooking type
            'businessCategories.1.required' => 'Veuillez sélectionner au minimum un types de cuisine pour être correctement référencer par l\'application',
            'businessCategories.1.array' => 'Veuillez spécifier au minimum un type de cuisine',
        ];
        // Opening hours
        foreach (\App\Utilities\DateTools::getDaysArray() as $dayIndex => $dayLabel) {
            $messages['openingHours.' . $dayIndex . '.1.start.before_or_equal'] = "L'heure de fermeture du " . strtolower($dayLabel)
                    . " matin doit être supérieure à l'heure d'ouverture";
            $messages['openingHours.' . $dayIndex . '.2.start.before_or_equal'] = "L'heure de fermeture du " . strtolower($dayLabel)
                    . " après-midi doit être supérieure à l'heure d'ouverture";
            $messages['openingHours.' . $dayIndex . '.2.start.after_or_equal'] = "L'heure d'ouverture du " . strtolower($dayLabel)
                    . " après-midi doit être supérieure à l'heure de fermeture du matin";
            $messages['openingHours.' . $dayIndex . '.1.start.required'] = "Veuillez saisir l'heure d'ouverture du " . strtolower($dayLabel) . " matin";
            $messages['openingHours.' . $dayIndex . '.1.end.required'] = "Veuillez saisir l'heure de fermeture du " . strtolower($dayLabel) . " matin";
            $messages['openingHours.' . $dayIndex . '.2.start.required_unless'] = "Veuillez saisir l'heure d'ouverture du " . strtolower($dayLabel) . " après-midi";
            $messages['openingHours.' . $dayIndex . '.2.end.required_unless'] = "Veuillez saisir l'heure de fermeture du " . strtolower($dayLabel) . " après-midi";
        }
        return $messages;
    }

}
