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
        if ($this->ajax() === true) {
            $rules = array();

            switch ($this->get('action')) {
                case 'add_gallery':
                    $validator = \Illuminate\Support\Facades\Validator::make($this->all(), [
                                'new_gallery_name' => 'required|min:2|max:255',
                    ]);
                    if ($validator->fails()) {
                        return $validator->getRules();
                    }
                    break;
                case 'add_dish':
                    $validator = \Illuminate\Support\Facades\Validator::make($this->all(), [
                                'new_dish_name' => 'required|min:2|max:255',
                                'new_dish_description' => 'nullable|min:2|max:255',
                                'new_dish_price' => 'required|numeric|min:2',
                                'new_dish_price_cents' => 'nullable|max:2',
                    ]);
                    if ($validator->fails()) {
                        return $validator->getRules();
                    }
                    break;
                case 'delete_gallery':

                    break;
                case 'add_close_period':
                    $closeStartDate = new \DateTime($this->get('close_start'));
                    //var_dump($closeStartDate);
                    //die($closeStartDate->format('Y-m-d H:i:s'));
                    $validator = \Illuminate\Support\Facades\Validator::make($this->all(), [
                                'close_name' => 'required|min:2|max:255',
                                'end_date' => 'date_format:Y/m/d|after:' . $closeStartDate->format('Y/m/d'),
                                    //'datetime_reservation' => 'date_format:d/m/Y|after_or_equal:' . $dateNow,
                    ]);
                    if ($validator->fails()) {
                        return $validator->getRules();
                    }
                    break;
                case 'add_media_to_gallery':

                    break;
                case 'add_menu':
                    $validator = \Illuminate\Support\Facades\Validator::make($this->all(), [
                                'menu_name' => 'required|min:2|max:255',
                    ]);
                    if ($validator->fails()) {
                        return $validator->getRules();
                    }
                    break;
                case 'add_video':
                    $validator = \Illuminate\Support\Facades\Validator::make($this->all(), [
                                'video' => 'required|mimes:mp4'
                    ]);
                    if ($validator->fails()) {
                        return $validator->getRules();
                    }
                    break;
                case 'add_employee':
                    $validator = \Illuminate\Support\Facades\Validator::make($this->all(), [
                                'new_employee_firstname' => 'required|min:2|max:255',
                                'new_employee_lastname' => 'required|min:2|max:255',
                                'job_type' => 'required',
                                'new_employee_position' => 'required',
                    ]);
                    if ($validator->fails()) {
                        return $validator->getRules();
                    }
                    break;
                case 'add_story':
                    $validator = \Illuminate\Support\Facades\Validator::make($this->all(), [
                                'new_story_year' => 'required',
                                'new_story_title' => 'required|min:2|max:255',
                                'new_story_description' => 'nullable|min:2|max:255',
                    ]);
                    if ($validator->fails()) {
                        return $validator->getRules();
                    }

                    break;
            }

            return $rules;
        } else {
            //Une regex contenant des pipe doit être validé avant ou après 
            $validator = \Illuminate\Support\Facades\Validator::make($this->all(), [
                        //format autorisé +(502)(4 à 10) ou +(41)(4 à 10) ou (0041)(4 à 10)ou (00502)(4 à 10)
                        'call_number.1' => ['required', 'regex:/(^[0]?\d{2}\ ?\d{3}\ ?\d{2}\ ?\d{2}$)|(^\d{10,11}$)/'],
                        'call_number.4' => ['required', 'regex:/(^[0]?\d{2}\ ?\d{3}\ ?\d{2}\ ?\d{2}$)|(^\d{10,11}$)/'],
                        'call_number.2' => ['nullable', 'regex:/((^[0]?\d{2}\ ?\d{3}\ ?\d{2}\ ?\d{2}$)|(^\d{10,11}$)/'],
                        'call_number.3' => ['nullable', 'regex:/(^[0]?\d{2}\ ?\d{3}\ ?\d{2}\ ?\d{2}$)|(^\d{10,11}$)/'],
            ]);

            if ($validator->fails()) {
                return $validator->getRules();
            }

            //minima maxima for dishes
            $min = $this->get('average_price_min');
            $max = $this->get('average_price_max');

            $rules = [
                //self::$rules_phone,
                // Location
                'name' => 'required|min:2|max:255',
                'address.street' => 'required|min:3|max:255',
                'address.street_number' => 'required|max:45',
                'address.postal_code' => 'required|max:11',
                'address.region' => 'required|max:255',
                'address.city' => 'required|max:255',
                'address.id_country' => 'required',
                //Web 
                'site_url' => 'nullable|regex:/(https?:\/\/)?([\a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ._-da-z\.-]+)\.?([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
                'email' => 'nullable|email',
                // Cooking types
                'businessCategories.1' => 'required|array|min:1',
                //menu
                //Menu average price
                'average_price_min' => 'nullable|numeric|min:1',
                'average_price_max' => 'nullable|numeric|min:1|between:' . $min . ',' . $max,
            ];
            // Opening hours
            foreach (\App\Utilities\DateTools::getDaysArray() as $dayIndex => $dayLabel) {
                $rules['openingHours.' . $dayIndex . '.1.start'] = 'required'; //|before_or_equal:openingHours.'.$dayIndex.'.1.end';
                $rules['openingHours.' . $dayIndex . '.1.end'] = 'required|after_or_equal:openingHours.' . $dayIndex . '.1.start';

                $rules['openingHours.' . $dayIndex . '.2.start'] = 'required_unless:openingHours.' . $dayIndex . '.2.no_break,1|after_or_equal:openingHours.' . $dayIndex . '.1.end'
                ; //.'before_or_equal:openingHours.'.$dayIndex.'.2.end';
                $rules['openingHours.' . $dayIndex . '.2.end'] = 'required_unless:openingHours.' . $dayIndex . '.2.no_break,1|after_or_equal:openingHours.' . $dayIndex . '.2.start';
            }
            return $rules;
        }
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
            'call_number.1.regex' => 'Veuillez indiquer un numéro de réservation.',
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
            //Validation Ajax (gallery)
            'new_gallery_name.required' => 'Veuillez spécifier un nom pour votre gallerie',
            'new_gallery.required_with' => 'Veuillez saisir un nom pour votre gallerie',
            //menu
            'menu_name.required' => 'Veuillez saisir un nom pour votre menu',
            //video
            'video.mimes' => 'Votre vidéo doit être au format MP4',
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
