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
            'email' => 'nullable|email',
            //user
             'name' => 'required|min:2|max:255',
            
        ];

        return $rules;
    }

    public function messages() {
        $messages = [
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'name.required' => 'Veuillez saisir le nom de votre restaurant.',
            'name.min' => 'Veuillez renseigner au minimum 2 caractère pour le nom de votre restaurant',
            'name.max' => 'Merci de ne pas renseigner plus de 255 caractères pour le nom de votre restaurant',
        ];
        
    }
}
