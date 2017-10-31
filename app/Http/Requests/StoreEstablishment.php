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

    public function checkEstablishment($establishment, $rules) {
        if (checkModel($establishment)) {
            $establishmentId = explode('/', $this->getPathInfo());
            if (!isset($establishmentId[2])) {
                $rules['nameExist'] = ['required'];
                //return $rules;
            }
        } else {
            $rules['name'] = ['required|min:2|max:255'];
        }
        return $rules;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $rules = array();
        switch ($this->get('action')) {
            case 'add_gallery':
                $rules = [
                    'new_gallery_name' => 'required|min:2|max:255',
                    'new_gallery' => 'required',
                ];
                break;
            case 'add_dish':
                $rules = [
                    'new_dish_name' => 'required|min:2|max:255',
                    'new_dish_description' => 'nullable|min:2|max:255',
                    'new_dish_price' => 'required|numeric|min:2',
                    'new_dish_price_cents' => 'required|max:2',
                ];
            case 'delete_gallery':
            case 'delete_close_period':
            case 'add_media_to_gallery':
            case 'add_home_pictures':
                
                break;
            case 'add_close_period':
                $closeStartDate = new \DateTime($this->get('close_start'));
                $rules = [
                    'close_name' => 'required|min:2|max:255',
                    'close_start' => 'required_with:close_name|date_format:Y-m-d',
                    'close_end' => 'required_with:close_name|date_format:Y-m-d|after:' . $closeStartDate->format('Y/m/d'),
                ];
                break;
            case 'add_menu':
                $rules = [
                    'menu_name' => 'required|min:2|max:255',
                    'new_menu' => 'mimes:png,jpg,jpeg,pdf,doc,docx',
                ];
                break;
            case 'add_daily_menu':
                $rules = [
                    'new_daily_menu' => 'required',
                ];
                break;
            case 'add_daily_menu':
                $rules = [
                    'new_daily_menu' => 'required',
                ];
                break;
            case 'add_video':
                $rules = [
                    'video' => 'required|mimes:mp4',
                ];
                break;
            case 'add_thumbnail':
                $rules = [
                    'thumbnail' => 'required|mimes:png,jpg,jpeg',
                ];
                break;
            case 'add_logo':
                $rules = [
                    'logo' => 'required|mimes:png,jpg,jpeg',
                ];
                break;
            case 'add_employee':
                $rules = [
                    'new_employee_firstname' => 'required|min:2|max:255',
                    'new_employee_lastname' => 'required|min:2|max:255',
                    'job_type' => 'required',
                    'new_employee_position' => 'required',
                ];
                break;
            case 'add_story':
                $rules = [
                    'new_story_year' => 'required',
                    'new_story_title' => 'required|min:2|max:255',
                    'new_story_description' => 'nullable|min:2|max:255',
                    'new_story' => 'required',
                ];
                break;
            default :
                $name = $this->get('name');
                $establishment = \App\Models\Establishment::where('name', $name)->first();

                if (checkModel($establishment)) {
                    $establishmentId = explode('/', $this->getPathInfo());
                    if (!isset($establishmentId[2])) {
                        $rules = [
                            'nameExist' => 'required',
                        ];
                        return $rules;
                    }
                }

                $nbr = count($this->input('home_pictures')) - 1;
                foreach (range(0, $nbr) as $index) {
                    $rules['home_pictures.' . $index] = 'required|max:4000';
                }

                //minima maxima for dishes
                $min = $this->get('average_price_min');
                $max = $this->get('average_price_max');
                $rules = [
                    //self::$rules_phone,
                    // Location
                    'name' => 'required|min:2|max:255',
                    'address.geocoded' => 'required|' . \Illuminate\Validation\Rule::in(['true', 1]),
                    'address.street' => 'required|min:3|max:255',
                    'address.street_number' => 'required|max:45',
                    'address.postal_code' => 'required|max:11',
                    'address.region' => 'required|max:255',
                    'address.city' => 'required|max:255',
                    'address.id_country' => 'required',
                    //Web 
                    'site_url' => 'nullable|regex:/(https?:\/\/)?([\a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ._-da-z\.-]+)\.?([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
                    'email' => 'required|email',
                    //description
                    'description' => 'nullable|min:2',
                    // Cooking types
                    'businessCategories.1' => 'required|array|min:1|max:5',
                    'businessCategories.2' => 'nullable|array|max:5',
                    //galerie
                    'logo' => 'nullable|mimes:png,jpg,jpeg',
                    //Menu average price
                    'average_price_max' => 'nullable|required_with:average_price_min|numeric|min:1|between:' . $min . ',' . $max,
                    'average_price_min' => 'nullable|required_with:average_price_max',
                    //call number
                    'call_number.1' => 'required|regex:/^[0-9 ]+$/',
                    'call_number.4' => 'required|regex:/^[0-9 ]+$/',
                    'call_number.2' => 'nullable|regex:/^[0-9 ]+$/',
                    'call_number.3' => 'nullable|regex:/^[0-9 ]+$/',
                ];

                // Opening hours
//                foreach (\App\Utilities\DateTools::getDaysArray() as $dayIndex => $dayLabel) {
//                    $rules['openingHours.' . $dayIndex . '.1.start'] = 'required';
//                    $rules['openingHours.' . $dayIndex . '.1.end'] = 'after_or_equal:openingHours.' . $dayIndex . '.1.start';
//
//                    $rules['openingHours.' . $dayIndex . '.2.start'] = ':openingHours.' . $dayIndex . '.1.no_break,1|after_or_equal:openingHours.' . $dayIndex . '.1.end';
//                    $rules['openingHours.' . $dayIndex . '.2.end'] = 'required_unless:openingHours.' . $dayIndex . '.1.no_break,1|after_or_equal:openingHours.' . $dayIndex . '.2.start';
//                }
                break;

            case 'add_daily_menu':
                $rules = [
                    'new_daily_menu' => 'required|mimes:png,jpg,jpeg,pdf,doc,docx',
                ];
                break;
        }
        return $rules;
    }

    public function messages() {
        $messages = [
            //Emplacement msg
            'name.required' => 'Veuillez saisir le nom de votre restaurant.',
            'name.min' => 'Veuillez renseigner au minimum 2 caractères pour le nom de votre restaurant.',
            'name.max' => 'Merci de ne pas renseigner plus de 255 caractères pour le nom de votre restaurant.',
            'address.geocoded.required' => "L'adresse de votre établissement n'a pu être géolocalisée, merci de modifier votre saisie afin que l'adresse soit confirmée1.",
            'address.geocoded.in' => "L'adresse de votre établissement n'a pu être géolocalisée, merci de modifier votre saisie afin que l'adresse soit confirmée2.",
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
            'call_number.4.required' => 'Veuillez indiquer un numéro pour vous joindre.',
            'call_number.4.regex' => 'Veuillez indiquer un numéro pour vous joindre.',
            'call_number.3.regex' => 'Le numéro de fax ne doit pas contenir plus de 11 numéro.',
            'call_number.2.regex' => 'Le numéro de réservation ne doit pas contenir de caractères.',
            //Web
            'site_url.regex' => 'Veuillez saisir une adresse correcte pour votre site internet.',
            'email.email' => 'Veuillez saisir une adresse e mail valide.',
            'email.required' => 'Veuillez saisir une adresse e-mail.',
            //cooking type
            'businessCategories.1.required' => 'Veuillez sélectionner au minimum un types de cuisine pour être correctement référencer par l\'application.',
            'businessCategories.1.array' => 'Veuillez spécifier au minimum un type de cuisine.',
            'businessCategories.1.max' => 'Un maximum de 5 types de cuisine est accepté.',
            'businessCategories.2.max' => 'Un maximum de 5 types de spécialité est accepté.',
            //Validation Ajax (gallery)
            'new_gallery_name.required' => 'Veuillez spécifier un nom pour votre gallerie.',
            'new_gallery.required_with' => 'Veuillez saisir un nom pour votre gallerie.',
            //menu
            'menu_name.required' => 'Veuillez saisir un nom pour votre menu',
            'menu_name.min' => 'le nom de votre menu est trop cout',
            'menu_name.max' => 'Le nom de votre menu est trop long',
            'new_menu.required' => 'Une image est requise',
            'average_price_max.between' => 'Le prix maximum doit être inférieur au prix minimum',
            'average_price_max.required_with' => 'Veuillez indiquer le prix maximum',
            'average_price_max.numeric' => 'Le prix maximum doit être inférieur au prix minimum',
            'average_price_max.min' => 'Veuillez indiquer le prix maximum',
            'average_price_min.required_with' => 'Veuillez indiquer le prix minimum',
            //video
            'video.mimes' => 'Format incorrect',
            'video.required' => 'Format incorrect',
            //Gallerie
            'new_gallery_name.required' => 'Veuillez saisir un nom pour votre gallerie',
            'new_gallery_name.min' => 'Le nom de votre gallerie est trop court',
            'new_gallery_name.max' => 'Le nom de votre gallerie est trop long',
            'new_gallery.required' => 'Veuillez séléctioner au minimum une image pour créer une gallerie',
            'logo.mime' => 'Votre logo dois être de format JPEG ou PNG',
            //dishe
            'new_dish_name.required' => 'Veuillez saisir un nom pour votre assiette',
            'new_dish_name.min' => 'Le nom d\'assiette est trop court',
            'new_dish_name.max' => 'Le nom d\' assiette est trop long',
            'new_dish_description.min' => 'La description est trop courte',
            'new_dish_description.max' => 'La description est trop longue',
            'new_dish_price.required' => 'Le prix est requis',
            'new_dish_price.min' => 'Prix d\'assiette incorrecte',
            'new_dish_price.numberic' => 'Prix d\'assiette incorrecte',
            'new_dish_price_cents.required' => 'Prix d\'assiette incorrecte',
            'new_dish_price_cents.max' => 'Prix d\'assiette incorrecte',
            //add_close_period
            'close_name.required' => 'Veuillez nommez la période de fermeture',
            'close_name.min' => 'Le nom est trop court',
            'close_name.max' => 'Le nom est trop long',
            'close_end.after' => 'La date de fin doit être supérieure à la date d\'ouverture',
            'close_end.required_with' => 'Veuiillez entrer date de début',
            'close_start.required_with' => 'Veuillez entrer une date de fin',
            //employeee
            'new_employee_firstname.required' => 'Le nom est requis',
            'new_employee_firstname.min' => 'Le nom est trop court',
            'new_employee_firstname.max' => 'Le nom est trop long',
            'new_employee_lastname.required' => 'Le prenom est requis',
            'new_employee_lastname.min' => 'Le prenom est trop court',
            'new_employee_lastname.max' => 'Le prenom est trop long',
            'job_type.required' => 'Veuillez choisir le type d\'employé',
            'new_employee_position.required' => 'Veuillez sélectionner un type de poste',
            //history
            'new_story_year.required' => 'Veuillez séléctionner une date',
            'new_story_title.required' => 'Veuillez entrer un tire évoquant votre histoire',
            'new_story_title.min' => 'Le titre est trop court',
            'new_story_title.max' => 'Le titre est trop long',
            'new_story_description.min' => 'La description est trop courte',
            'new_story_description.max' => 'La description est trop longue',
            'new_story.required' => 'Veuillez insérer une image',
            //call number
            'call_number.1.regex' => 'Veuillez contrôler le format de votre numéro',
            'call_number.4.regex' => 'Veuillez contrôler le format de votre numéro',
            'call_number.2.regex' => 'Veuillez contrôler le format de votre numéro',
            'call_number.3.regex' => 'Veuillez contrôler le format de votre numéro',
            'call_number.1.required' => 'Veuillez saisir un numéro de réservation',
            'call_number.4.required' => 'Veuillez saisir un numéro de contact',
            'nameExist.required' => 'Le restaurant est déja inscrit en base. Merci de contacter un administrateur',
        ];
        // Opening hours
        foreach (\App\Utilities\DateTools::getDaysArray() as $dayIndex => $dayLabel) {
            $messages['openingHours.' . $dayIndex . '.1.start.before_or_equal'] = "L'heure de fermeture du " . strtolower($dayLabel)
                    . " matin doit être supérieure à l'heure d'ouverture";
            $messages['openingHours.' . $dayIndex . '.1.end.after_or_equal'] = "L'heure de fermeture du " . strtolower($dayLabel)
                    . " matin doit être supérieure à l'heure d'ouverture";
            $messages['openingHours.' . $dayIndex . '.2.end.after_or_equal'] = "L'heure de fermeture du " . strtolower($dayLabel)
                    . " après-midi doit être supérieure à l'heure d'ouverture";
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
