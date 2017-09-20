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
            'gender' => 'nullable',
            'company.name' => 'nullable|min:3|max:255',
            'firstname' => 'required|min:3|max:255',
            'lastname' => 'required|min:3|max:255',
            'phoneNumber.number' => 'required',
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
            'company.name' => 'nullable|min:2|max:255',
            'address.firstname' => 'required|min:2|max:255',
            'address.lastname' => 'required|min:2|max:255',
            'address.street' => 'required|min:3|max:255',
            'address.street_number' => 'required|max:45',
            'address.po_box' => 'max:11',
            'address.postal_code' => 'required|max:11',
            'address.city' => 'required|max:255',
            'address.id_country' => 'required',
            'address.email' => 'required|email',
            //call number
            'phoneNumber.number' => 'required|regex:/^[0-9 ]+$/',
            'call_number.5' => 'nullable|regex:/^[0-9 ]+$/',
            'call_number.4' => 'required|regex:/^[0-9 ]+$/',
            'call_number.2' => 'nullable|regex:/^[0-9 ]+$/',
            'call_number.3' => 'nullable|regex:/^[0-9 ]+$/',
            //confirmation cgv
            'accept_cgv' => 'required',
        ];

        return $rules;
    }

    public function messages() {
        $messages = [
            //Credentiel
            //'gender.required' => 'Veuillez sélectionner votre genre.',
            'company.min' => 'Veuillez renseigner au minimum 2 caractères pour le nom de votre société',
            'company.max' => 'Merci de ne pas renseigner plus de 255 caractères pour le nom de votre société',
            'firstname.required' => 'Veuillez saisir votre prénom.',
            'firstname.min' => 'Veuillez renseigner au minimum 2 caractères pour votre prénom',
            'firstname.max' => 'Merci de ne pas renseigner plus de 255 caractères pour votre prénom',
            'lastname.required' => 'Veuillez renseigner votre nom',
            'lastname.min' => 'Veuillez renseigner au minimum 2 caractères pour votre nom',
            'lastname.max' => 'Merci de ne pas renseigner plus de 255 caractères pour votre prénom',
            'email.required' => 'Veuillez saisir une adresse email.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'email.unique' => 'Cette adresse email est déja dans notre base, merci de conntacter un administrateur.',
            'emailBill.required' => 'Veuillez saisir une adresse e mail.',
            'emailBill.email' => 'Veuillez saisir une adresse e mail valide.',
            'emailBill.unique' => 'Cette adresse email est déja dans notre base, merci de conntacter un administrateur.',
            'phoneNumber.number.required' => 'Veuillez indiquer un numéro pour vous joindre.',
            'password.required' => 'Veuillez renseigner un mot de passe pour vous connecter à votre espace privé',
            'password.min' => 'Votre mot de passe est trop faible',
            'password.confirmed' => 'Votre mot de passe n\'est pas identique',
            'password_confirmation.required' => 'Veuillez confirmer votre mot de passe',
            'password_confirmation.confirmed' => 'Votre mot de passe n\'est pas identique',
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
            'address.street.required' => 'Veuillez saisir une adresse de facturation.',
            'address.street.min' => 'Le nom de la rue doit contenir au minimum 3 caractères.',
            'address.street_number.required' => 'Vous devez spécifier un numéro de rue.',
            'address.postal_code.required' => 'Vous devez spécifier un code postal.',
            'address.street_number.required' => 'Vous devez spécifier un numéro de rue.',
            'address.street_number.max' => 'Merci de ne pas renseigner plus de 45 caractères pour le numéro de rue',
            'address.po_box.max' => 'Merci de ne pas renseigner plus de 45 caractères pour le PO BOX',
            'address.postal_code.required' => 'Vous devez spécifier un code postal.',
            'address.postal_code.max' => 'Code postal tro long.',
            'address.city.required' => 'Vous devez spécifier une ville pour votre établissement.',
            'address.city.max' => 'Merci de ne pas renseigner plus de 255 caractères pour la ville',
            'address.email.required' => 'Veuillez saisir une adresse email.',
            //'address.id_country.required' => '',
            //call number
            'call_number.5.required' => 'Veuillez saisir un numéro de téléphone de contact.',
            'call_number.5.regex' => 'Veuillez contrôler le format de votre numéro',
            'call_number.4.required' => 'Veuillez contrôler le format de votre numéro.',
            'call_number.4.regex' => 'Veuillez contrôler le format de votre numéro.',
            'call_number.2.regex' => 'Veuillez contrôler le format de votre numéro',
            'call_number.3.regex' => 'Veuillez contrôler le format de votre numéro',
            //confirmation
            'accept_cgv.required' => 'Veuillez acceptez les conditions générales d\'utilisation et la politique de confidentialité.',
        ];

        return $messages;
    }

}
