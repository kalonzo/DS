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
            'user.gender' => 'required',
            'user.company' => 'nullable|min:3|max:255',
            'user.firstname' => 'required|min:3|max:255',
            'user.lastname' => 'required|min:3|max:255',
            'user.email' => 'required|string|email|max:255',//|unique:'.\App\Models\User::TABLENAME.',email',
            'user.call_number.'.\App\Models\CallNumber::TYPE_PHONE_CONTACT => 'required|regex:/^[0-9 ]+$/',
            'user.password' => 'required|min:6|string|confirmed:password_confirmation',
            'user.password_confirmation' => 'required',
            
            'business_type' => 'required',
            
            'id_subscription' => 'required',
            'duration' => 'required',
            
            'payment_method' => 'required',
            
            'bill.title' => 'required',
            'bill.company_name' => 'nullable|min:2|max:255',
            'bill.firstname' => 'required|min:2|max:255',
            'bill.lastname' => 'required|min:2|max:255',
            'address.street' => 'required|min:3|max:255',
            'address.street_number' => 'required|max:45',
            'address.po_box' => 'max:11',
            'address.postal_code' => 'required|max:11',
            'address.city' => 'required|max:255',
            'address.id_country' => 'required',
            'bill.email' => 'required|email',
            
            'bill.call_number.'.\App\Models\CallNumber::TYPE_PHONE_PRO => 'required|regex:/^[0-9 ]+$/',
            'bill.call_number.'.\App\Models\CallNumber::TYPE_PHONE_CONTACT => 'nullable|regex:/^[0-9 ]+$/',
            'bill.call_number.'.\App\Models\CallNumber::TYPE_MOBILE => 'nullable|regex:/^[0-9 ]+$/',
            'bill.call_number.'.\App\Models\CallNumber::TYPE_FAX => 'nullable|regex:/^[0-9 ]+$/',
            
            'accept_cgv' => 'required',
        ];
        return $rules;
    }

    public function messages() {
        $messages = [
            'user.gender.required' => 'Veuillez sélectionner votre civilité',
            'user.company.min' => 'Veuillez renseigner au minimum 2 caractères pour le nom de votre société',
            'user.company.max' => 'Merci de ne pas renseigner plus de 255 caractères pour le nom de votre société',
            'user.firstname.required' => 'Veuillez saisir votre prénom.',
            'user.firstname.min' => 'Veuillez renseigner au minimum 2 caractères pour votre prénom',
            'user.firstname.max' => 'Merci de ne pas renseigner plus de 255 caractères pour votre prénom',
            'user.lastname.required' => 'Veuillez renseigner votre nom',
            'user.lastname.min' => 'Veuillez renseigner au minimum 2 caractères pour votre nom',
            'user.lastname.max' => 'Merci de ne pas renseigner plus de 255 caractères pour votre prénom',
            'user.email.required' => 'Veuillez saisir une adresse email.',
            'user.email.email' => 'Veuillez saisir une adresse email valide.',
            'user.email.unique' => 'Cette adresse email est déja dans notre base, merci de conntacter un administrateur.',
            'user.call_number.'.\App\Models\CallNumber::TYPE_PHONE_CONTACT.'.required' => 'Veuillez saisir un numéro de téléphone de contact.',
            'user.call_number.'.\App\Models\CallNumber::TYPE_PHONE_CONTACT.'.regex' => 'Veuillez contrôler le format de votre numéro.',
            'user.password.required' => 'Veuillez renseigner un mot de passe pour vous connecter à votre espace privé',
            'user.password.min' => 'Votre mot de passe est trop faible',
            'user.password.confirmed' => 'Votre mot de passe n\'est pas identique',
            'user.password_confirmation.required' => 'Veuillez confirmer votre mot de passe',
            'user.password_confirmation.confirmed' => 'Votre mot de passe n\'est pas identique',
            
            'business_type.required' => 'Veuillez sélectionner le type d\'établissement désiré',
            
            'id_subscription.required' => 'Veuillez sélectionner un abonnement',
            'duration.required' => "Veuillez sélectionner une durée d'engagement",
            
            'payment_method.required' => 'Veuillez sélectionner une méthode de paiement',
            
            'bill.title.required' => 'Veuillez sélectionner la civilité de vos informations de facturation',
            'bill.company_name.required' => 'Veuillez saisir le nom de votre société.',
            'bill.company_name.min' => 'Veuillez renseigner au minimum 2 caractères pour le nom de votre société',
            'bill.company_name.max' => 'Merci de ne pas renseigner plus de 255 caractères pour le nom de votre société',
            'bill.firstname.required' => 'Veuillez saisir votre prénom.',
            'bill.firstname.min' => 'Veuillez renseigner au minimum 2 caractères pour votre prénom',
            'bill.firstname.max' => 'Merci de ne pas renseigner plus de 255 caractères pour votre prénom',
            'bill.lastname.required' => 'Veuillez renseigner votre nom',
            'bill.lastname.min' => 'Veuillez renseigner au minimum 2 caractères pour votre nom',
            'bill.lastname.max' => 'Merci de ne pas renseigner plus de 255 caractères pour votre prénom',
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
            'address.id_country.required' => 'Vous devez spécifier un pays',
            'bill.email.required' => 'Veuillez saisir une adresse e mail.',
            'bill.email.email' => 'Veuillez saisir une adresse e mail valide.',
            
            'bill.call_number.'.\App\Models\CallNumber::TYPE_PHONE_PRO.'.required' => 'Veuillez saisir un numéro de téléphone de contact.',
            'bill.call_number.'.\App\Models\CallNumber::TYPE_PHONE_PRO.'.regex' => 'Veuillez contrôler le format de votre numéro',
            'bill.call_number.'.\App\Models\CallNumber::TYPE_PHONE_CONTACT.'.regex' => 'Veuillez contrôler le format de votre numéro.',
            'bill.call_number.'.\App\Models\CallNumber::TYPE_MOBILE.'.regex' => 'Veuillez contrôler le format de votre numéro',
            'bill.call_number.'.\App\Models\CallNumber::TYPE_FAX.'.regex' => 'Veuillez contrôler le format de votre numéro',
            
            'accept_cgv.required' => 'Veuillez acceptez les conditions générales d\'utilisation et la politique de confidentialité.',
        ];

        return $messages;
    }

}
