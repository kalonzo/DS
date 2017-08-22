<?php

namespace App\Http\Requests;

class StoreBooking extends \App\Http\FormRequest {

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
            'email' => 'required|email',
            'firstname' => 'required|min:2|max:255',
            'lastname' => 'required|min:2|max:255',
        ];

        return $rules;
    }

    public function messages() {
        $messages = [
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'email.required' => 'Veuillez saisir une adresse email.',
            'firstname.required' => 'Veuillez saisir votre prénom.',
            'firstname.min' => 'Veuillez renseigner au minimum 2 caractère pour votre prénom',
            'firstname.max' => 'Merci de ne pas renseigner plus de 255 caractères pour votre prénom',
            'lastname.required' => 'Veuillez saisir votre nom.',
            'lastname.min' => 'Veuillez renseigner au minimum 2 caractère pour votre nom',
            'lastname.max' => 'Merci de ne pas renseigner plus de 255 caractères pour votre nom',
        ];
        return $messages;
    }
}
