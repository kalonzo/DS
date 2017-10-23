<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserAdmin extends FormRequest
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
        $rules = [
            'firstname' => 'required|min:3|max:255',
            'lastname' => 'required|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::TABLENAME.',email',
            'password' => 'required|min:6|string|confirmed:password_confirmation',
            'password_confirmation' => 'required'
            ];
        return $rules;
    }
    
    
    public function messages() {
        $messages = [
            'firstname.required' => 'Veuillez saisir votre prénom.',
            'firstname.min' => 'Veuillez renseigner au minimum 2 caractères pour votre prénom',
            'firstname.max' => 'Merci de ne pas renseigner plus de 255 caractères pour votre prénom',
            'lastname.required' => 'Veuillez renseigner votre nom',
            'lastname.min' => 'Veuillez renseigner au minimum 2 caractères pour votre nom',
            'lastname.max' => 'Merci de ne pas renseigner plus de 255 caractères pour votre prénom',
            'email.required' => 'Veuillez saisir une adresse email.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'email.unique' => 'Cette adresse email est déja dans notre base, merci de conntacter un administrateur.',
            'password.required' => 'Veuillez renseigner un mot de passe pour vous connecter à votre espace privé',
            'password.min' => 'Votre mot de passe est trop faible',
            'password.confirmed' => 'Votre mot de passe n\'est pas identique',
            'password_confirmation.required' => 'Veuillez confirmer votre mot de passe',
            'password_confirmation.confirmed' => 'Votre mot de passe n\'est pas identique',
        ];

        return $messages;
    }
}
