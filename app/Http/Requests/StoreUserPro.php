<?php

namespace App\Http\Requests;

class StoreUserPro extends \App\Http\FormRequest {

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
            'gender' => 'required',
            'company.name' => 'nullable|min:3|max:255',
            'firstname' => 'required|min:3|max:255',
            'lastname' => 'required|min:3|max:255',
           // 'phoneNumber[number]' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:6|string|confirmed:password_confirmation',
            'password_confirmation' => 'required',
            //Business categories
            'business_type' => 'required',
            //subscription
            'id_subscription' => 'required',
            //Payments methode
            'payment_method' => 'required',
            //Info bill
            'company.name' => 'required|min:2|max:255',
            //'address[firstname]' => 'required|min:2|max:255',
            'address.lastname' => 'required|min:2|max:255',
            'address.street' => 'required|min:3|max:255',
            'address.street_number' => 'required|max:45',
            'address.po_box' => 'max:11',
            'address.postal_code' => 'required|max:11',
            'address.city' => 'required|max:255',
            'address.id_country' => 'required',
            'email' => 'required|email',
        ];
        
            //call number
            $rules['call_number[5]'] = 'nullable|regex:/^[0-9 ]+$/';
            //$rules['call_number.4'] = 'required|regex:/^[0-9 ]+$/';
            $rules['call_number.2'] = 'nullable|regex:/^[0-9 ]+$/';
            $rules['call_number.3'] = 'nullable|regex:/^[0-9 ]+$/';
        
        return $rules;
    }

    public function messages() {
        $messages = [
            //Credentiel
            'gender.required' => 'Veuillez sélectionner votre genre.',
            'company.required' => 'Veuillez saisir le nom de votre société.',
            'company.min' => 'Veuillez renseigner au minimum 2 caractères pour le nom de votre société',
            'company.max' => 'Merci de ne pas renseigner plus de 255 caractères pour le nom de votre société',
            'firstname.required' => 'Veuillez saisir votre prénom.',
            'firstname.min' => 'Veuillez renseigner au minimum 2 caractères pour votre prénom',
            'firstname.max' => 'Merci de ne pas renseigner plus de 255 caractères pour votre prénom',
            'lastname.required' => 'Veuillez renseigner votre nom',
            'lastname.min' => 'Veuillez renseigner au minimum 2 caractères pour votre nom',
            'lastname.max' => 'Merci de ne pas renseigner plus de 255 caractères pour votre prénom',
            'email.required' => 'Veuillez saisir une adresse e mail.',
            'email.email' => 'Veuillez saisir une adresse e mail valide.',
            'phoneNumber[number].required' => 'Veuillez indiquer un numéro pour vous joindre.',
            'password.required' => 'Veuillez renseigner un mot de passe pour vous connecter à votre espace privé',
            'password.min' => 'Votre mot de passe est trop faible',
            'password-confirm.required' => 'Veuillez confirmer votre mot de passe',
            'password-confirm.confirmed' => 'Votre mot de passe n\'est pas identique',
            //Business categories
            'business_type.required' => 'Veuillez sélectionner le type d\'établissement désiré',
            //subscription
            'id_subscription.required' => 'Veuillez sélectionner un abonnement',
            //Payments methode
            'payment_method.required' => 'Veuillez sélectionner une méthode de paiement',
            //Info bill
            'company.name.required' => 'Veuillez saisir le nom de votre société.',
            'company.name.min' => 'Veuillez renseigner au minimum 2 caractères pour le nom de votre société',
            'company.name.max' => 'Merci de ne pas renseigner plus de 255 caractères pour le nom de votre société',
            'address.firstname.required' => 'Veuillez saisir votre prénom.',
            'address.firstname.min' => 'Veuillez renseigner au minimum 2 caractères pour votre prénom',
            'address.firstname.max' => 'Merci de ne pas renseigner plus de 255 caractères pour votre prénom',
            'address.lastname.required' => 'Veuillez renseigner votre nom',
            'address.lastname.min' => 'Veuillez renseigner au minimum 2 caractères pour votre nom',
            'address.lastname.max' => 'Merci de ne pas renseigner plus de 255 caractères pour votre prénom',
            'address.street.required' => 'Veuillez saisir une adresse pour votre établissement.',
            'address.street.min' => 'Le nom de la rue doit contenir au minimum 3 caractères.',
            'address.street_number.required' => 'Vous devez spécifier un numéro de rue.',
            'address.postal_code.required' => 'Vous devez spécifier un code postal.',
            'address.street_number.required' => '|max:45',
            'address.street_number.max' => '|max:45',
            'address.po_box.max' => 'required|max:11',
            'address.postal_code.required' => '|max:11',
            'address.postal_code.max' => '|max:11',
            'address.city.required' => 'Vous devez spécifier une ville pour votre établissement.',
            'address.city.max' => 'Merci de ne pas renseigner plus de 255 caractères pour la ville',
                //'address.id_country.required' => '',
            //call number
            'call_number[5]' => 'regex:/^[0-9 ]+$/',
            'call_number[4].required' => 'Veuillez saisir un numéro ou vous joindre',
            'call_number[2]' => 'nullable|regex:/^[0-9 ]+$/',
            'call_number[3]' => 'nullable|regex:/^[0-9 ]+$/',
        ];

        return $messages;
    }

}
