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
            //Credentiel
            'gender' => 'required',
            'company.name' => 'required|min:3|max:255',
            'firstname' => 'required|min:3|max:255',
            'lastname' => 'required|min:3|max:255',
            'email' => 'required|email',
            'phoneNumber.number' => 'required|min:11|numeric',
            'password' => 'required|confirmed:password_confirm',
            //Business categories
            'business_type' => 'required',
            //subscription
            'id_subscription' => 'required',
            //Payments methode
            'payment_method' => 'required',
            //Info bill
            'company.name' => 'required|min:2|max:255',
            'address.firstname' => 'required|min:2|max:255',
            'address.lastname' => 'required|min:2|max:255',
            'address.street' => 'required|min:3|max:255',
            'address.street_number' => 'required|max:45',
            'address.po_box' => 'required|max:11',
            'address.postal_code' => 'required|max:11',
            'address.city' => 'required|max:255',
            'address.id_country' => 'required',
            'email' => 'required|email',
        ];
        return $rules;
    }

    public function messages() {
        $messages = [
            //Credentiel
            'gender.required' => 'Veuillez séléctioner votre genre.',
            'company.required' => 'Veuillez saisir le nom de votre société.',
            'company.min' => 'Veuillez renseigner au minimum 2 caractère pour le nom de votre société',
            'company.max' => 'Merci de ne pas renseigner plus de 255 caractères pour le nom de votre société',
            'firstname.required' => 'Veuillez saisir votre prénom.',
            'firstname.min' => 'Veuillez renseigner au minimum 2 caractère pour votre prénom',
            'firstname.max' => 'Merci de ne pas renseigner plus de 255 caractères pour votre prénom',
            'lastname.required' => 'Veuillez renseigner votre nom',
            'lastname.min' => 'Veuillez renseigner au minimum 2 caractère pour votre nom',
            'lastname.max' => 'Merci de ne pas renseigner plus de 255 caractères pour votre prénom',
            'email.required' => 'Veuillez saisir une adresse email.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'phoneNumber.number.required' => 'Veuillez indiquer un numéro pour vous joindre.',
            'phoneNumber.number.min' => 'Le numéro ne doit pas contenir plus de 11 numéro.',
            'phoneNumber.number.numeric' => 'Votre numéro de dois pas contenir de caractères',
            'password.required' => 'Veuillez rendeigner un mot de passe pour vous connecter à votre espace privé',
            'password.confirmed' => 'Veuillez confirmer votre mot de passe',
            //Business categories
            'business_type.required' => 'Veuillez séléctioner le type d\'établissemnt désiré',
            //subscription
            'id_subscription.required' => 'Veuillez séléctioner un abonement',
            //Payments methode
            'payment_method.required' => 'Veuillez séléctionner une méthode de paiment',
            //Info bill
            'company.name.required' => 'Veuillez saisir le nom de votre société.',
            'company.name.min' => 'Veuillez renseigner au minimum 2 caractère pour le nom de votre société',
            'company.name.max' => 'Merci de ne pas renseigner plus de 255 caractères pour le nom de votre société',
            'address.firstname.required' => 'Veuillez saisir votre prénom.',
            'address.firstname.min' => 'Veuillez renseigner au minimum 2 caractère pour votre prénom',
            'address.firstname.max' => 'Merci de ne pas renseigner plus de 255 caractères pour votre prénom',
            'address.lastname.required' => 'Veuillez renseigner votre nom',
            'address.lastname.min' => 'Veuillez renseigner au minimum 2 caractère pour votre nom',
            'address.lastname.max' => 'Merci de ne pas renseigner plus de 255 caractères pour votre prénom',
            'address.street.required' => 'Veuillez saisir une adresse pour votre établissement.',
            'address.street.min' => 'Le nom de la rue dois contenir au minimum 3 caractères.',
            'address.street_number.required' => 'Vous devez spécifiez un numéro de rue.',
            'address.postal_code.required' => 'Vous devez spécifier un code postal.',
            'address.street_number.required' => '|max:45',
            'address.street_number.max' => '|max:45',
            'address.po_box.required' => 'required|max:11',
            'address.po_box.max' => 'required|max:11',
            'address.postal_code.required' => '|max:11',
            'address.postal_code.max' => '|max:11',
            'address.city.required' => 'Vous devez spécifiez une ville pour votre établissement.',
            'address.city.max' => 'Merci de ne pas renseigner plus de 255 caractères pour la ville',
            //'address.id_country.required' => '',
        ];

        return $messages;
    }

}
